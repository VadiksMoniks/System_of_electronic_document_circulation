This is just a simple try of realisation DCM-system as a pet-project.
Technologies whitch I used:
  - Simple MVC realisation on PHP
  - Imagic library for converting documents into .pdf
  - jQuery and AJAX for asynchronous requests
  - HTML and CSS
  - MySQL
  - PHPMailer for mail notification.
Description:
  This project implements a simple DCM-system with options such ass creating, storing, downloading and deleting files.
  This project has such classes:
    -router parse the URL and call the functions from controller classes
    -Controllers call to model and view functions
    -Models create and store the documents, make queries to DB, sends e-mail notifications and return data
    -View call template page with recieved data
    Also I use traits for data validation and making queries to DB
How it works in general:
  User can create a document based on a template, then this document will be stored on a server and admin will check it. Admin can confirm it or delete if something wrong.
  Then recievers could sign it with their signatures and after the signing document converts into .pdf so user could download it from now.
  For registre users must confirm their e-mail by following the link sended in letter after registration. Also users could turn on/off mail notification whitch tells them that the document is ready for download.
  Admin can sort documents by the name and status(uncheked, unsigned). Recievers could see the list of documents for signing and sign them.
  
To see the latest updates check development branch.
