# About Amazon s3 Module

Using this extension we can synchronize directory from Magento to Amazon s3.

## Installation

### Installation with modman

Clone it within modman via `https://` or `git://`:

    modman clone git https url
    modman clone git ssh url

### Installation without modman

Copy all the files in your magento root directory

### After installation

Clean the cache after installation!

## Admin Settings

Please configure settings from Admin >> System >> Configuration >> WAGENTO >> Amazon Sync
Please make sure directory must be exist on Magento.
Magento directory value must be start from Magento root path like if you want to sync media/test directory then
Magento directory value will be "media/test"

## Testing

Please take backup of Amazon s3 bucket or do testing with testing bucket.
Please save all settings and after that click on "Run Synchronization" button. So all files will synchronize with Amazon s3
