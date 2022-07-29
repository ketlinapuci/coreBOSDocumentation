---
title: 'coreBOSCP - Installation and Configuration'
metadata:
    description: 'coreBOS Customer Portal'
    author: 'Joe Bordes'
content:
    items:
        - '@self.children'
    limit: 5
    order:
        by: date
        dir: desc
    pagination: true
    url_taxonomy_filters: true
taxonomy:
    category:
        - coreBos
    tag:
        - portal
---
---

The coreBOSCP application is a rest/webservice interface program to an existing coreBOS application. This means that it has no need for a database of it's own, all the information it manipulates is read from or sent to an associated coreBOS which saves it to the configured database there.

This makes installing and configuring the application rather easy and mostly a case of configuring a coreBOS user and pointing the coreBOSCP application to it's associated coreBOS.

## coreBOS Webservice Enhancements

If you are trying to get this working on a vtiger CRM 5.4 (6.x), we have had to extend the default vtiger CRM web service considerably.

[This patch and file set](coreboscp_vt54.zip) should do the trick but it is obsolete, the tickets above describe much better the necessary code changes. Copy the files into the root of your install, apply the patch to the code and execute the SQL in your database.

<div class="notices red">
Please backup your code and database before applying to any production site and please test on a copy before doing so. </div>

## coreBOS Customer Portal User
To access your coreBOS through the webservice interface an active user in the application must be given. So the first step of the installation process is to access your coreBOS install and create a new user. This user should be assigned it's own role and profile, and the profile should be configured with the correct permissions to show information on the customer portal.

coreBOSCP portal application will use this user to access coreBOS and will respect the role and profile permissions assigned to that user. So if some field on Contacts shouldn't be seen on the portal it should be hidden in this user's profile. The same approach is taken for modules. Although coreBOSCP has a set of hard coded modules which it supports, which cannot be extended without programming, we can restrict this set by not giving access to a module to the customer portal user created in the coreBOS application.

Certain “*relation*” fields are mandatory. All access to entities through the customer portal are restricted by the contact and his account. So all entities will be filtered by their relation field to contacts and accounts. For example, we will only see invoice that belong to the contact or his account, likewise we will only see trouble tickets related to the contact and his account. To be able to achieve this, the portal user MUST have access to the fields that establish this relation.

<div class="notices red">
NOTE: coreBOSCP <strong>does not</strong> use nor respect the customer portal extension of vtigerCRM. That extension is used by the vtiger CRM Customer Portal, we do not use any of that configuration.</div>

On the new user's detail or preferences view we will find a field call **access key**, the value of this field is needed to configure coreBOSCP

## coreBOSCP Install and Configuration
1. copy the code to a directory accessible from the web user on the server where you want to have the customer portal. It is recommendable that you version that code using git:

```
git clone https://github.com/tsolucio/coreBOSCP.git coreboscp
```
2. give read/write permission to the web user to all directories in the structure. Especially important are: assets and protected/runtime
3. edit protected/config/PortalConfig.php and set the variables
- a.**$evocp_Server_Path** must be the full URL to the associated coreBOS install. Obviously, this implies that the server you are doing the install on MUST have continuous access to the coreBOS application
- b.**$evocp_Login_User** and **$coreBOSCP_Access_Key** define the user with which we will access coreBOS as defined in the previous section.
- c.**$evocp_AttachmentFolderName** is the name of the folder within which you want any trouble ticket attachments to be uploaded

This screencast shows a live session of installing and configuring access.

[plugin:youtube](https://youtu.be/03kOfVyDDH0)

## Contacts Access

We must now explicitly give access to each contact we want by means of the fields designated for this on the contact's record in coreBOS.