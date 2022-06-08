# Unofficial laravel package for Chapa's API

If your are doing a laravel project and want to integrate chapa's payment
solution, this package would help big time.

Go to [Chapa](https://dashboard.chapa.co/) to signup and get your public and private key

## Documentation

Please visit [Chapa](https://developer.chapa.co/docs/accept-payments/) for full documentation.


## Guide

Please visit [Developers Guide](https://developer.chapa.co/laravel-sdk/) for full guide and examples.


## API Reference

#### Collecting Customer Information

```https
  POST https://api.chapa.co/v1/transaction/initialize
```

| Parameter                    | Type     | Required | Description                                                                                                                                                                                         |
| :--------------------------- | :------- | :------- | :-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `key`                        | `string` | **Yes**. | This will be your public key from Chapa. When on test mode use the test key, and when on live mode use the live key.                                                                                |
| `email`                      | `string` | **Yes**. | A customer’s email. address.                                                                                                                                                                        |
| `amount`                     | `string` | **Yes**. | The amount you will be charging your customer.                                                                                                                                                      |
| `first_name`                 | `string` | **Yes**. | A customer’s first name.                                                                                                                                                                            |
| `last_name`                  | `string` | **Yes**. | A customer’s last name.                                                                                                                                                                             |
| `tx_ref`                     | `string` | **Yes**. | A unique reference given to each transaction.                                                                                                                                                       |
| `callback_url`               | `string` | **Yes**. | Function that runs when payment is successful. This should ideally be a script that uses the verify endpoint on the Paystack API to check the status of the transaction.                            |
| `currency`                   | `string` | **Yes**. | The currency in which all the charges are made. Currency allowed is ETB.                                                                                                                            |
| `customization[tiitle] `     | `string` | **No**.  | The customizations field (optional) allows you to customize the look and feel of the payment modal. You can set a logo, the store name to be displayed (title), and a description for the payment.. |
| `customization[description]` | `string` | **No**.  | The customizations field (optional) allows you to customize the look and feel of the payment modal.                                                                                                 |

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

### Security

If you discover any security related issues, please email kidusy@chapa.co instead of using the issue tracker.

## Credits

- [kidus363](https://github.com/chapa)
- [isrugeek](https://github.com/chapa)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
