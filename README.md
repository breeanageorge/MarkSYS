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