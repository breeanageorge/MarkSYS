MarkSYS Test Project 001
========================

###Installation Steps:
1. fork the repository
2. checkout forked repository to your local machine
3. run `composer install` (Composer must be installed. More details [here](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx))
4. set database parameters in `app/config/parameters.yml`
5. run application. Details [here](http://symfony.com/doc/current/setup.html#running-your-symfony-application)
6. more info on installing and running Symfony application [here](http://symfony.com/doc/current/setup.html)


###Application Details:
This application is a simple "contact us" form. Access the contact page at `/` path. Once
a contact request is submitted, it is being persisted into MySQL table. Submitted contact
requests can be viewed on a separate page. Access new (unread) contact requests at this
path - `/records/new`. All contact requests can be accessed at this path - `/records`.
One contact request at a time is being displayed. If more than one contact request is
available in the current path, pagination links are shown. Individual contact requests are
accessible at this path - `/record/{uuid}`, where `{uuid}` is the UUID of the record.

###Assignment
1. add anti-bot protection on the contact form
2. style the contact request display page
3. add a menu/navigation on top of the contact request display page to allow seamless
switching between displaying new, or all contact requests
4. mark a contact request as read when displayed (set `isRead` field to `true`)
5. fix any potential errors/problems with the application

###Submission
Once done, send us a link to your repository containing the completed assignment. Specify
branch, if different from master. Describe what you have done with the assignment.

###Changes
1. Anti-bot protection
    I had to do some research for this task, and I found this blog post about creating a hidden time element (http://vvv.tobiassjosten.net/symfony/stopping-spam-with-symfony-forms/). I ended up adding a new hidden form element that uses the date time in seconds as it's value. I then validate in form.js to check if the time has been tampered with in any way. I check if it has a value, is a number, less than 7 seconds have passed, or if more than one day has passed. 
2. Style the contact request display page
    I personally like a minimalist look when it comes to web page styling. I often find pages are very busy and can be distracting. I took inspiration from your web page, adding a white header bar and blue accents. I found the cube picture on your about us page and edited it so that it would fill the whole background. I maintained this same style on the other pages as well. This was all done in the html.twig files, both in the files under src/AppBundle/Resources/views and the base file under app/Resources/views.
3. Add a menu/navigation for the pages that display new and all contact requests
    I added a navigation element to the white header bar that I had originally made for the contact form. I added this to the all records, new records, and single records page for quick navigation between all of them. This was done in the html.twig files, both in the files under src/AppBundle/Resources/views and the base file under app/Resources/views.
4. Mark a contact request as read when displayed.
    I started by adding a function in src/AppBundle/Entity/Repositry/ContactRepository.php called updateIsRead. This function has an input of the $uuid and outputs "true" or "false". I have the function check to see if the contact request has already been read, if so, it skips the update statement and returns false. If it has not been read, then it will update the isRead to true with setIsRead('true') and return true.
    Next, I added code to the src/AppBundle/Controller/AdminController.php file. I added a statement to run my updateIsRead function to the loadRecordAction function, so when someone views the individual record, it will update the isRead field. Then, I added several lines to the indexAction function. I start by getting the total number of requests and the uuid from $pagination, then I run the updateIsRead function setting a variable to catch the returned response. If the response is true, meaning this is the first time this request has been viewed, I update the number of total requests to be the previous total minus one. I did this because I noticed that if I tried to go to the last request on the new records page before refreshing, it would return an error because the total number of requests had gone down. 
5. Fix and potential errors/problems
    I did not encounter any errors that were not caused by me learning to use the system properly.
