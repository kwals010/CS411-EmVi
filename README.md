EMVI
====

This project is for the capstone CS411 class at Old Dominion Universtiy. EmVi is a Marketing 
Email creation and approval system. Content is uploaded and passed through the system in a 
series of approval snd modifications until it is ready for distrobution. It provides access 
controls, upload features, retrieval methods and tasking solutions.

Working demo at
http://kwals010.phpemvi.com/emvi

Installation notes:
For HTML screenshots, install imagemagick:
>sudo aptitude install imagemagick wkhtmltopdf
>sudo apt-get install libicu48
>sudo apt-get install xvfb

For email sending, install sendmail: 
>sudo apt-get install sendmail
>sudo sendmailconfig

For the Rackspace CDN API
>sudo apt-get install php5-curl

