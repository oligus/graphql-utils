<?php declare(strict_types=1);

namespace GraphQLUtils\Types\Objects;

use Exception;
use GraphQL\Type\Definition\ObjectType;
use GraphQLUtils\TypeRegistry;
use Locale;
use Money\Money;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use NumberFormatter;

/**
 * Class AmountType
 * @package GraphQLUtils\Types\Objects
 */
class AmountType extends ObjectType
{
    /**
     * AmountType constructor.
     */
    public function __construct()
    {
        $config = [
            'name' => 'Amount',
            'description' => 'Amount',
            /**
             * @return array<string,mixed>
             * @throws Exception
             */
            'fields' => function (): array {
                return [
                    'sum' => [
                        'type' => TypeRegistry::money(),
                        'description' => 'Sum',
                        'resolve' => function (Money $money): Money {
                            return $money;
                        }
                    ],
                    'currency' => [
                        'type' => TypeRegistry::string(),
                        'description' => 'Currency',
                        'resolve' => function (Money $money): string {
                            return $money->getCurrency()->getCode();
                        }
                    ],
                    'formatted' => [
                        'type' => TypeRegistry::string(),
                        'description' => 'Formatted',
                        'args' => [
                            'locale' => TypeRegistry::string()
                        ],
                        /** @param array<mixed> $args */
                        'resolve' => function (Money $money, array $args): string {
                            $locale = $args['locale'] ?? Locale::getDefault();

                            $currencies = new ISOCurrencies();
                            $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
                            $moneyFormatter = new IntlMoneyFormatter($formatter, $currencies);

                            return $moneyFormatter->format($money);
                        }
                    ]
                ];
            }
        ];

        parent::__construct($config);
    }
}
