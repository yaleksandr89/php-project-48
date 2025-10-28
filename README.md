# Вычислитель отличий (php-project-48)

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

## Проверка кода

```bash
make lint
```

---

## Тестирование

```bash
make test
```

Покрытие тестов (coverage):

```bash
make test-coverage
```

---

## Использование

После установки команда `gendiff` будет доступна глобально (если путь настроен). Посмотреть справку:

```bash
gendiff -h
```

Сравнение двух JSON файлов:

```bash
gendiff tests/Fixtures/file1.json tests/Fixtures/file2.json
```

Пример вывода:

```
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

## 📺 Демонстрация работы

[![asciinema gendiff demo](https://asciinema.org/a/XXXXXXXX.svg)](https://asciinema.org/a/XXXXXXXX)

_(демонстрация будет добавлена позже)_

---

## Поддерживаемые форматы

- JSON
- YAML

_(поддержка INI — в разработке...)_

---

## Форматы вывода

- **stylish** — древовидное форматирование (по умолчанию)
- **plain** — плоский человекочитаемый текст
- **json** — JSON-структура для машинной обработки

_(демонстрации будут добавлены позже)_

---

## Используемые технологии

- PHP 8.3
- Composer
- PHPUnit
- PHP_CodeSniffer
- Docopt
- Symfony YAML

---

## Основные команды

```bash
make install          # Установка зависимостей
make refresh          # Переустановка + обновление автозагрузки
make validate         # Проверка composer.json
make lint             # Проверка кода по PSR-12
make test             # Запуск тестов
make test-coverage    # Генерация отчёта покрытия
gendiff -h            # Справка по утилите
gendiff <f1> <f2>     # Сравнение файлов
```
