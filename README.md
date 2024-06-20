# AsiaYo pretest

## Build

```bash
docker build -t asiayo_pretest_img . --no-cache

docker run --rm --name asiayo_pretest -p 8000:8000 -d asiayo_pretest_img
```

Will listen to `127.0.0.1:8000`

## Usage

```js
headers: "Accept:application/json";
endpoint: "/api/currency/exchange";

params: source, target, amount;

example: "http://127.0.0.1:8000/api/currency/exchange?source=USD&target=JPY&amount=1123.222222";

response: {
    "msg": "success",
    "amount": "125,577.12"
}
```

## Tests

```bash
docker exec -it asiayo_pretest bash

# In container
php artisan test
```
