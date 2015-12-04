##Meanbee Postcode

Postcode anywhere allows users to easily search for their address using their postcode, this uses the [PostcodeAnywhere](http://www.postcodeanywhere.co.uk/) Service.

    "repositories": [
        {
            "type":"vcs",
            "url":"git@bitbucket.org:meanbee/postcode-mage2.git"
        }
    ],
    "require":{
         "meanbee/postcode-mage2"
    }

    composer install

##Installation

    composer require meanbee/postcode-mage2

##Developing Using Docker

    docker-compose run setup
    docker-compose up -d

visit [`http://postcode-mage2.docker`](http://postcode-mage2.docker).

###Tips:

You can use a custom branch and a local repository by adding the following lines in your Magento installs `composer.json`:

    "repositories": [
        {
            "type":"vcs",
            "url":"/path/to/module"
        }
    ],
    "require":{
         "meanbee/postcode-mage2":"dev-your-branch-name"
    }

    composer install
    
    
