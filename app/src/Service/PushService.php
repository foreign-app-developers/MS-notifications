<?php

namespace App\Service;

use App\Entity\Notification;
use App\Entity\UserRequisite;
use App\NotificationInterface;
use Doctrine\ORM\EntityManagerInterface;
use Google\Exception;
use Google_Client;
use Google_Exception;
use Google_Service_FirebaseCloudMessaging;


class PushService implements NotificationInterface
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    function getOATHToken()
    {
        $client = new Google_Client();
        try {
            $client->setAuthConfig(__DIR__ . '/PrivateKey.json');
            $client->addScope(Google_Service_FirebaseCloudMessaging::CLOUD_PLATFORM);

            $savedTokenJson = $this->readSavedToken();

            if ($savedTokenJson) {
                $client->setAccessToken($savedTokenJson);
                $accessToken = $savedTokenJson;
                if ($client->isAccessTokenExpired()) {
                    $accessToken = $this->generateToken($client);
                    $client->setAccessToken($accessToken);
                }
            } else {
                $accessToken = $this->generateToken($client);
                $client->setAccessToken($accessToken);
            }

            return $accessToken["access_token"];


        } catch (Google_Exception|Exception $e) {}
        return false;
    }

    function readSavedToken() {
        $tk = @file_get_contents(__DIR__ . '/token.cache');
        if ($tk) return json_decode($tk, true); else return false;
    }
    function writeToken($tk): void
    {
        file_put_contents(__DIR__ . '/token.cache',$tk);
    }

    function generateToken($client)
    {
        $client->fetchAccessTokenWithAssertion();
        $accessToken = $client->getAccessToken();

        $tokenJson = json_encode($accessToken);
        $this->writeToken($tokenJson);

        return $accessToken;
    }


    function sendNotification(Notification $notification): void
    {
        $toUserIds = $notification->getToVal();
        $userRequisiteRepository = $this->entityManager->getRepository(UserRequisite::class);
        $toAddresses = [];
        foreach ($toUserIds as $userId) {
            $userRequisite = $userRequisiteRepository->findOneBy(['userId' => $userId, 'type' => 'push']);
            $toAddresses[] = $userRequisite->getRequisite();
        }
        foreach ($toAddresses as $token ) {
            $accessToken = $this->getOATHToken();
            $payload = ["message" => ["token" => $token, "notification" => ["title" => $notification->getTitle(), "body" => $notification->getContent()]]];
            $postdata = json_encode($payload);

            $ch = curl_init('https://fcm.googleapis.com/v1/projects/' . $_ENV['GOOGLE_PROJECT_NAME'] . '/messages:send');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $accessToken,
            ]);

            curl_exec($ch);
            curl_close($ch);
        }


    }


}