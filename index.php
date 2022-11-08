<?php

// define('DEMO_JWT', 'eyJhbGciOiJIUzI1NiJ9.eyJtZXJjdXJlIjp7InB1Ymxpc2giOlsiKiJdLCJzdWJzY3JpYmUiOlsiaHR0cHM6Ly9leGFtcGxlLmNvbS9teS1wcml2YXRlLXRvcGljIiwie3NjaGVtZX06Ly97K2hvc3R9L2RlbW8vYm9va3Mve2lkfS5qc29ubGQiLCIvLndlbGwta25vd24vbWVyY3VyZS9zdWJzY3JpcHRpb25zey90b3BpY317L3N1YnNjcmliZXJ9Il0sInBheWxvYWQiOnsidXNlciI6Imh0dHBzOi8vZXhhbXBsZS5jb20vdXNlcnMvZHVuZ2xhcyIsInJlbW90ZUFkZHIiOiIxMjcuMC4wLjEifX19.KKPIikwUzRuB3DTpVw6ajzwSChwFw5omBMmMcWKiDcM');

/***

# Decode JWT

PAYLOAD : 
```
{
  "mercure": {
    "publish": [
      "*"
    ],
    "subscribe": [
      "https://example.com/my-private-topic",
      "{scheme}://{+host}/demo/books/{id}.jsonld",
      "/.well-known/mercure/subscriptions{/topic}{/subscriber}"
    ],
    "payload": {
      "user": "https://example.com/users/dunglas",
      "remoteAddr": "127.0.0.1"
    }
  }
}
```
*/


define('DEMO_JWT', 'eyJhbGciOiJIUzI1NiJ9.eyJtZXJjdXJlIjp7InB1Ymxpc2giOlsiKiJdfX0.PXwpfIGng6KObfZlcOXvcnWCJOWTFLtswGI5DZuWSK4');

/***

# Decode JWT

HEADER :

```
{
  "alg": "HS256"
}
```

PAYLOAD : 

```
{
  "mercure": {
    "publish": [
      "*"
    ]
  }
}
```

VERIFY SIGNATURE : 

```
HMACSHA256(
  base64UrlEncode(header) + "." +
  base64UrlEncode(payload),
  !ChangeThisMercureHubJWTSecretKey!      <-- MERCURE_SUBSCRIBER_JWT_KEY=
)

```

 */

$postData = http_build_query([
    'topic' => 'https://localhost/demo/books/1.jsonld',
    'data' => json_encode(
        [
            'title' => uniqid('mercure-server-resp-', true)
        ]
    ),
]);

echo file_get_contents(
    'https://localhost/.well-known/mercure', 
    false, 
    stream_context_create(
        [
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-type: application/x-www-form-urlencoded\r\nAuthorization: Bearer ".DEMO_JWT,
                'content' => $postData,
            ], 
            "ssl" => [
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ]
        ]
    )
);