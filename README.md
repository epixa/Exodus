# Exodus - control your connections


The Exodus App can be used to determine which users a person follows on twitter 
have identical accounts on identi.ca.  Any user can be queried by anyone.  It is
built with the Epixa library on Zend Framework and requires PHP 5.3.



# How does it work?

Given a username, exodus queries the twitter api for all of the people that the 
given user follows (the user's friends).  It queries the api through Zend 
Framework's http client.  This particular query can only return 100 people at a 
time, so it will execute this request with a pagination "cursor" until all users
are returned.

Once all of the friends are retrieved, exodus iterates over each person and 
queries the identi.ca api for a user that has the exact same username.  At the 
time of this writing, the identi.ca api does not support querying for multiple 
users at a time (unlike the twitter api), so each user must be retrieved by its 
own request.

The collection of all users that are on both twitter and identi.ca are then 
rendered to the screen in a table with links to both their twitter and identi.ca
profiles.


# Caching

Every time a user's friends are queried from twitter, the resulting collection 
(after all paginated requests are made) is cached for all subsequent requests 
for twelve hours.

The result of every request for a user on identi.ca (found or not) is cached 
individually.  If a user is found, the request is cached indefinitely.  If a 
user is not found, the request is cached for six hours.  Obviously it would be 
ideal not to have so many requests being made to identi.ca, but since that is 
the api we have to work with, this caching scheme means that exodus gets faster 
the more people queries are made.  If two different users follow many of the 
same people, then queries to each user will benefit from the cache of the other.


# Authentication

Twitter authentication is performed via OAuth and is enforced installation-wide 
by configuration settings.  If you do not enable OAuth configuration, then 
exodus will unhindered without it.  The only reason to use authentication is to 
better handle the api rate limits imposed by Twitter.

If you are installing exodus for your personal use, go ahead and disable Oauth.
Without authentication, exodus can only make up to 150 requests to Twitter each 
hour per IP Address.  This should be more than necessary for personal 
installations.

If you are installing exodus for public use, you should enable OAuth.  
Authenticated requests to Twitter have a rate limit of 350 requests per hour per 
user.  In other words, the burden of rate limits is shifted to the people using 
your application rather than the application itself.



# Installation

You will need a web-server (Apache, Nginx) and PHP 5.3.x to run this. Then:

  1. Clone this repo
  2. Add or remove oauth settings to config/settings/&lt;environment&gt;.php
  3. If you specify a specific directory for filesystem caching, make it writable