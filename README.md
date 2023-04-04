# random-string
Installation

```bash
composer require ketut/random-string
```

How to use
```bash
use Ketut\RandomString\Random;

$randomString = (new Random)
  ->length(32)
  ->lowercase()
  ->uppercase()
  ->numeric()
  ->generate();
 
$arrayRandomString = (new Random)
  ->length(32)
  ->block(5)
  ->lowercase()
  ->uppercase()
  ->numeric()
  ->generateBlock();
```
