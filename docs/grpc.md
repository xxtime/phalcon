## docs
* https://medium.com/@poyu677/grpc-%E4%BD%BF%E7%94%A8-php-%E5%AF%A6%E4%BD%9C-ab485e9f1044
* https://github.com/grpc/grpc/tree/master/src/php
* https://docs.servicestack.net/grpc-php
* https://github.com/grpc/grpc/tree/master/src/php#build-and-install-the-grpc-c-core-library

## composer
```json
{
  "description": "示例配置",
  "require": {
    "grpc/grpc": "~1.30.0",
    "google/protobuf": "^v3.12.0"
  },
  "autoload": {
    "psr-4": {
      "GPBMetadata\\": ["grpc/GPBMetadata/"]
    }
  }
}
```
