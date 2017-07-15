# Fasty - a fast and simple PHP framework
(Currently under heavy development)
## Installation

Installing Fasty is **super** easy, just follow the steps bellow

> composer create-project fasty/framework project_name

Or download the latest stable release

1. Set the web servers root directory to the /Public folder
1. Open console/command prompt and cd into the Fasty root folder
1. Run composer install and wait until composer finishes downloading the necessary files (if don't have composer set up, you can do so by visiting this link: https://getcomposer.org/doc/00-intro.md )
1. Set up the config.php file to match your own settings
1. Create something awesome!

Fasty doesn't require any console work on its own but it needs it for the initial installation

## Benchmarks

All of the benchmarks are done using Apaches benchmark tool called ApacheBench version 2.3
They are also done on my local machine (which isn't high spec), so the results are somewhat low

### Benchmark command

```bash
ab -n 1000 -c 100 http://localhost
```

### Machine specs
* Processor: Intel Core i5-4210U @ 1.70GHz
* RAM: 8 GB
* System: 64-bit Windows 10

### The actual results

1. Fasty - 53.91 _requests/second_ (MySQL connection, default file cache system)
1. Laravel - 13.59 _requests/second_ (MySQL connection, default file cache system)
1. CakePHP - 10.83 _requests/second_ (MySQL connection, default file cache system)
