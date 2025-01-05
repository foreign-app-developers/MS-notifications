# MS-notifications

**Для запуска проекта в dev режиме:**
```
make up Makefile.md
```
**Для запуска проекта в prod режиме:**
```
make up-stage Makefile.md
```
**Остановить prod:**
```
make down-stage Makefile.md
```
**для запуска telegram бота**
```
cd docker && docker-compose exec ms_notification php bin/console tg:start
```
