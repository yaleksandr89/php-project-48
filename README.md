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

**Gendiff** — CLI‑утилита на PHP 8.3 для сравнения конфигурационных файлов **JSON** и **YAML (YML)**.  
Определяет различия между файлами, формируя иерархическое *diff‑дерево* с поддержкой вложенных структур.  
Поддерживает несколько форматов вывода:
- **stylish** — древовидный формат (по умолчанию)
- **plain** — текстовый человеко‑читаемый формат
- **json** — JSON‑вывод для машинной обработки

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
 ├── Differ/         # Построение дерева различий (genDiff, buildDiff, readFile)
 ├── Formatters/     # Форматтеры вывода: stylish, plain, json
 ├── Parsing/        # Парсинг и чтение файлов
tests/
 └── DifferTest.php  # Тесты с DataProvider (json/yml × 4 формата вывода)
bin/
 └── gendiff         # CLI‑входная точка
```

## Команды Makefile

| Команда             | Назначение                                    |
|---------------------|-----------------------------------------------|
| `make install`      | Установить зависимости Composer               |
| `make validate`     | Проверить composer.json                       |
| `make lint`         | Проверить код по стандарту PSR‑12             |
| `make lint-fix`     | Исправить форматирование                      |
| `make test`         | Запустить PHPUnit‑тесты                       |
| `make refresh`      | Полная переустановка зависимостей             |

---

## Установка

```bash
git clone https://github.com/yaleksandr89/php-project-48.git
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

## Примеры работы

### Формат Stylish (по умолчанию)

```bash
gendiff tests/Fixtures/file1.json tests/Fixtures/file2.json
```

Вывод:

```bash
{
    common: {
      + follow: false
        setting1: Value 1
      - setting2: 200
      - setting3: true
      + setting3: null
      + setting4: blah blah
      + setting5: {
            key5: value5
        }
        setting6: {
            doge: {
              - wow:
              + wow: so much
            }
            key: value
          + ops: vops
        }
    }
    group1: {
      - baz: bas
      + baz: bars
        foo: bar
      - nest: {
            key: value
        }
      + nest: str
    }
  - group2: {
        abc: 12345
        deep: { id: 45 }
    }
  + group3: {
        deep: { id: { number: 45 } }
        fee: 100500
    }
}
```

### Формат Plain

```bash
gendiff tests/Fixtures/file1.yml tests/Fixtures/file2.yml --format plain
```

Вывод:

```
Property 'common.follow' was added with value: false
Property 'common.setting2' was removed
Property 'common.setting3' was updated. From true to null
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: [complex value]
Property 'common.setting6.doge.wow' was updated. From '' to 'so much'
Property 'common.setting6.ops' was added with value: 'vops'
Property 'group1.baz' was updated. From 'bas' to 'bars'
Property 'group1.nest' was updated. From [complex value] to 'str'
Property 'group2' was removed
Property 'group3' was added with value: [complex value]
```

### Формат JSON

```bash
gendiff tests/Fixtures/file1.json tests/Fixtures/file2.json --format json
```

Вывод аналогичен файлу `tests/Fixtures/jsonExcepted.txt`.

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

### Сравнение в формате JSON

[![asciinema gendiff JSON format demo](https://asciinema.org/a/1skNeceSbU01xcCKQ8WYBxWP6.svg)](https://asciinema.org/a/1skNeceSbU01xcCKQ8WYBxWP6)

**В записи показано:**

- Запуск команды `gendiff` с ключом `--format json`
- Сравнение двух JSON-файлов
- Вывод результата в формате JSON