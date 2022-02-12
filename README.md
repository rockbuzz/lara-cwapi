# Lara Cw Api

Api Cloudways

<p><img src="https://github.com/rockbuzz/lara-cwapi/workflows/Main/badge.svg"/></p>

## Requirements

PHP >=7.3

## Install

```bash
$ composer require rockbuzz/lara-cwapi
```

## Usage
---
**NOTE**
Sensitive values such as server and app id must be set in environment variables

---

```env
CLOUDWAYS_EMAIL=
CLOUDWAYS_API_KEY=
```

Pull repo changes and deploy them
```php
$ app('cloudways')->startGitPull(
    int $server,
    int $app,
    string $git,
    string $branch,
    string $path = ''
);
```
or
```env
CLOUDWAYS_SERVER_ID=
CLOUDWAYS_APP_ID=
CLOUDWAYS_GIT_URL=
CLOUDWAYS_GIT_BRANCH_NAME=
CLOUDWAYS_DEPLOY_PATH=
```
```bash
$ php artisan cw:deploy
```

Take application backup
```php
$ app('cloudways')->appManageBackup(
    int $server,
    int $app
);
```
or
```env
CLOUDWAYS_SERVER_ID=
CLOUDWAYS_APP_ID=
```
```bash
$ php artisan cw:app-backup
```

## Optional

```php
$ php artisan vendor:publish --provider="Rockbuzz\LaraCwApi\ServiceProvider" --tag="config"
```
## License

The Lara Cw Api is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).