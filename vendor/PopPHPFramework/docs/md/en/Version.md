Pop PHP Framework
=================

Documentation : Version
-----------------------

Home

The Version component simply provides the ability to determine which
version of Pop you current have, and what the latest available is. Also,
this component is used by the CLI component to perform the
dependency-check.

    use Pop\Version;

    echo Version::getVersion();

    if (Version::compareVersion(1.0) == 1) {
        echo 'The current version is less than 1.0';
    } else {
        echo 'The current version is greater than or equal to 1.0';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
