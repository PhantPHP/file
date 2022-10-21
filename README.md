# Files

## Requirments

PHP >= 8.1


## Install

`composer require phant/file`

## Usages

### File

```php
use Phant\File\File;

$file = new File('path/filename.ext');
```


#### Get file path

```php
$filePath = $file->getPath();
```


#### Verify if file exist file path

```php
$fileExist = $file->exist();
```


#### Delete file

```php
$file->delete();
```


#### Get temporary path

```php
$temoraryDirectory = $file->getTemoraryDirectory();
```


#### Clean filename

```php
$cleanFilename = File::cleanFilename($dirtyFilename);
```


#### Download file to temporary directory

```php
$file = File::download($fileUrl);
```



### Csv file

```php
use Phant\File\Csv;

$file = new File('path/filename.csv');
```


#### Verify columns

```php
$isConform = $file->verifyColumns($columns);
```


#### Get number of lines

```php
$nbLines = $file->getNbLines();
```


#### Read file by line

```php
foreach ($file->readFileByLine() as $line) {
	
}
```


### Zip file

```php
use Phant\File\Zip;

$file = new File('path/filename.zip');
```


#### Unarchive

```php
$files = $file->unarchive();
foreach ($files as $file) {
}
```

