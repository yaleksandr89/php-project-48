# Вычислитель отличий: сравнение файлов (php-project-48)

### Hexlet tests and linter status:

[![Actions Status](https://github.com/yaleksandr89/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/yaleksandr89/php-project-48/actions)
[![Workflow](https://github.com/yaleksandr89/php-project-48/actions/workflows/workflow.yml/badge.svg)](https://github.com/yaleksandr89/php-project-48/actions)

### SonarCloud Status:

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=yaleksandr89_php-project-48&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=yaleksandr89_php-project-48)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=yaleksandr89_php-project-48&metric=coverage)](https://sonarcloud.io/summary/new_code?id=yaleksandr89_php-project-48)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=yaleksandr89_php-project-48&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=yaleksandr89_php-project-48)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=yaleksandr89_php-project-48&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=yaleksandr89_php-project-48)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=yaleksandr89_php-project-48&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=yaleksandr89_php-project-48)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=yaleksandr89_php-project-48&metric=bugs)](https://sonarcloud.io/summary/new_code?id=yaleksandr89_php-project-48)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=yaleksandr89_php-project-48&metric=code_smells)](https://sonarcloud.io/summary/new_code?id=yaleksandr89_php-project-48)

---

## Описание проекта

**Gendiff** — утилита для сравнения двух конфигурационных файлов.  
Поддерживает форматы **JSON** и **YAML**.  
Результат можно выводить в нескольких форматах — **stylish**, **plain**, **json**.

---

## Установка

```bash
git clone https://github.com/yaleksandr89/php-project-48.git
cd php-project-48
make install
```

---

## Использование

После установки команда `gendiff` будет доступна глобально (если путь настроен).  
Посмотреть справку:

```bash
gendiff -h
```

Пример сравнения двух файлов (на примере JSON):

```bash
gendiff tests/Fixtures/file1.json tests/Fixtures/file2.json
```

Результат:

```bash
{
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
}
```

---

## Демонстрация работы

### Сравнение JSON-файлов

[![asciinema gendiff JSON demo](https://asciinema.org/a/loUSAgY5zyindr10qJsLl0Wvr.svg)](https://asciinema.org/a/loUSAgY5zyindr10qJsLl0Wvr)

**В записи показано:**
- Запуск команды `gendiff`
- Сравнение двух JSON-файлов
- Отображение различий в формате *stylish* (по умолчанию)

---

### Сравнение YAML-файлов

[![asciinema gendiff YAML demo](https://asciinema.org/a/8vvsWhdtuDi9X5W0IQmD8Anpt.svg)](https://asciinema.org/a/8vvsWhdtuDi9X5W0IQmD8Anpt)

**В записи показано:**
- Запуск команды `gendiff`
- Сравнение двух YAML-файлов
- Отображение различий в формате *stylish*

## Основные команды

```bash
make install                  # Установка зависимостей
make refresh                  # Переустановка + обновление автозагрузки
make validate                 # Проверка composer.json
make lint                     # Проверка кода по PSR-12
make test                     # Запуск тестов
make test-coverage            # Генерация отчёта покрытия
gendiff -h                    # Справка по утилите
gendiff <file-1> <file-2>     # Сравнение файлов
```