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

**Gendiff** — CLI-утилита на PHP 8.3 для сравнения конфигурационных файлов **JSON** и **YAML**. Определяет различия между файлами, формируя иерархическое diff-дерево с поддержкой
вложенных структур. Поддерживает несколько форматов вывода: `stylish`, `plain`, `json`.

## Технологии

- PHP 8.3
- PHPUnit 11
- Symfony YAML
- Composer Autoload (PSR-4)
- PSR-12 code style
- Makefile automation
- GitHub Actions + SonarCloud (для CI/CD и анализа качества кода)

## Структура проекта

```
src/
 ├── Differ/             # Построение дерева различий
 ├── Formatters/         # Форматтеры вывода (stylish, plain, json)
 ├── Parsing/            # Чтение и нормализация файлов
 ├── Gendiff.php         # Главный фасад проекта
tests/
 ├── Fixtures/           # Тестовые данные
 ├── GenDiffTest.php
 ├── GenDiffNestedTest.php
```

## Команды Makefile

| Команда               | Назначение                                         |
|-----------------------|----------------------------------------------------|
| `make install`        | Установить зависимости Composer                    |
| `make refresh`        | Установить зависимости и перегенерировать autoload |
| `make validate`       | Проверить корректность composer.json               |
| `make lint`           | Проверить код по стандарту PSR-12                  |
| `make lint-fix`       | Автоматически исправить ошибки форматирования      |
| `make test`           | Запустить PHPUnit-тесты с подсветкой               |
| `make gendiff-nested` | Проверить работу утилиты на вложенных JSON-файлах  |

---

## Установка

```bash
git clone https://github.com/<твой-username>/gendiff.git
cd gendiff
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

### Сравнение вложенных JSON-файлов (Nested Diff)

[![asciinema gendiff JSON demo](https://asciinema.org/a/Kiw724OEGT3Tg4UYCtuXALXr6.svg)](https://asciinema.org/a/Kiw724OEGT3Tg4UYCtuXALXr6)

**В записи показано:**

- Запуск команды `gendiff`
- Сравнение двух **вложенных JSON-файлов**
- Корректная обработка многоуровневых структур
- Формирование иерархического diff-дерева
- Отображение различий в формате *stylish* (по умолчанию)

---

### Сравнение вложенных YAML-файлов (Nested Diff)

[![asciinema gendiff YAML demo](https://asciinema.org/a/IjDFr7dv9Fl98jMA7emj79AYt.svg)](https://asciinema.org/a/IjDFr7dv9Fl98jMA7emj79AYt)

**В записи показано:**

- Запуск команды `gendiff`
- Сравнение двух **вложенных YAML-файлов**
- Корректная обработка многоуровневых структур
- Формирование иерархического diff-дерева
- Отображение различий в формате *stylish* (по умолчанию)

### Запуск тестов проекта

[![asciinema gendiff YAML demo](https://asciinema.org/a/j49B9HGAK3mlPWsfdFEU0VDQQ.svg)](https://asciinema.org/a/j49B9HGAK3mlPWsfdFEU0VDQQ)

**В записи показано:**

- Запуск команды `make test`
- Выполнение всех unit-тестов через PHPUnit 11
- Проверка корректности всех сценариев:
  - Flat JSON и YAML
  - Nested JSON и YAML
  - Исключения при ошибках парсинга
  - Проверка функции `toString()`
- Финальный результат: **OK (8 tests, 8 assertions)**

### Сравнение в формате Plain

[![asciinema gendiff plain demo](https://asciinema.org/a/mkUlgLCDfti2jffl14RdvU5UK.svg)](https://asciinema.org/a/mkUlgLCDfti2jffl14RdvU5UK)

**В записи показано:**
- Запуск команды `gendiff`
- Сравнение двух файлов с ключом `--format plain`
- Отображение изменений в текстовом виде
