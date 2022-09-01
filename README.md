# PHP Sequence Generator Package

Facilitates the generation and autocompletion of a sequential value in the database

```php
// Initialize Repository
$defaultRepository = new MysqlRepository(table: 'sequences');
$anotherRepository = new MysqlRepository(table: 'secuencias');

$normalizer = new Normalizer($defaultRepository);
$generator  = new Generator();
$resolver   = new SequentialIncrementer($normalizer, $generator);

// Define Series
$series = [
    Serie::for('number')->alias('invoice'),

    new Collection($anotherRepository, [
        Serie::for('serie_number')->styles([
            new FixedLength(8),
            new Prefixed('B')
        ]),
    ]),
];

// Make increments
$resolver->resolve('payments', $series);

```