TEST TASK 1
# CurrencyExchangeBundle
Create a **Symfony 3** bundle, which would:
Have
services to query different banks for specific currency pair exchange rate,
there should be at least **3** exchange rate providers.
Determine
which bank provides best exchange rate
Store
the exchange rates in persistent storage so it could be used as cache for last **3** hours.
Rate
storage options should be configurable by bundle configuration tree if more than one storage
option is available.
## Services
The
bundle should provide a service which would give the best exchange rate for the asked
currency pair.
The
mentioned service, should be able to collect all exchange rate providers, based on their service
tag:
**exchange.rate.provider** so that other providers could be hooked without interfering with the
bundle.
## Implementation details
The
bundle should be tested with **PHPSpec** or **PHPUnit**
Use
**PSR4**
and **PSR2**
standards.
There
should be a command **currency:rates** which shows a table of exchange rates for a given
currency pair.
There
should be a command **currency:rate:best** which gives the best exchange rate for a given
currency pair.
## Delivery
Code
should be shared using GIT repository.
It
should contain **composer.json** file to manage dependencies and integration details.
The
source code is the property of author.