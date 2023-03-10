# random-string
Generate random string

```bash
composer require ketut/random-string
```

```bash
use Ketut\RandomString\Random;

$randomString = (new Random)
  ->length(32)
  ->lowercase()
  ->uppercase()
  ->numeric()
  ->generate();
```
