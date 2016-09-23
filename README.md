# PHP-BDD

## Установка и настройка окружения

### Установка зависимостей

Необходима чистая машина с установленной Ubuntu 16.04 x86_64\. Для установки окружения необходимо запустить скрипт `provision.sh`, который выполнит установку всех необходимых компонентов для CI-сервера и сборки проекта.

Для начала нужно получить копию скрипта на целевой машишине, это можно сделать несколькими способами:

- Склонировать репозиторий на целевой машине
- Загрузить с помощью `scp` со своей машины на целевую
- Загузить с помощью `wget` с GitHub

Ниже пример как достигнуть этого с помощью `wget`

```sh
user@ci-server:~$ wget https://raw.githubusercontent.com/ITAttractor/PHP-BDD/master/provision.sh
```

Далее необходимо дать права на заупск скрипта и выполнить его из под sudo

```sh
user@ci-server:~$ chmod +x provision.sh
user@ci-server:~$ sudo ./provision.sh
```

Далее скрипт выполнит установку всех необходимых компонентов.

### Настройка Jenkins

После установки окружения нужно настроить Jenkins. Для этого необходимо зайти в веб интерфес Jenkins, по умолчанию доступен на порту 8080\. Например: `http://172.29.0.10:8080`

Далее создать конфигурацию для билда, для этого нужно.

1. Кликнуть по ссылке `New Item`.

![][new-item-screenshot]

2. Ввести название build-таска, выбрать тип(`Pipeline`) и создать его.

![][create-build-task-screenshot]

3. Ввести параметры для пайплайна и сохранить.

№   | Параметр       | Значение
--: | :------------- | :------------------------
1   | Defenition     | Pipeline script from SCM
2   | SCM            | Git
3   | Repository URL | `<ссылка_на_репозиторий>`
4   | Script Path    | Jenkinsfile

![][set-task-settings-screenshot]

5. Запустить билд

![][start-build-screenshot]

*Первый билд длится более длительное время чем обычно, это связано с тем, что скачиваются зависимоти для docker-контейнеров и php.*

## Окружение на котором производлась разработка и тестирование

- Ubuntu 16.04 x86_64
- Jenkins 2.7.4
- PHP 7.0
- Docker 1.12.1
- Symfony 2.8

[create-build-task-screenshot]: /manual-screenshots/2.png
[new-item-screenshot]: /manual-screenshots/1.png
[set-task-settings-screenshot]: /manual-screenshots/3.png
[start-build-screenshot]: /manual-screenshots/4.png
