---
title: 'Programmed Emails'
metadata:
    description: 'Set of various modules that will permit you to create powerful email templates and send them out on determined schedule.'
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
        - extension
    tag:
        - module
---

Set of various modules that will permit you to create powerful email templates and send them out on determined schedule.

===

### Goal of the Project
-------------------

The goal of this project is to permit the user to establish a set of
emails to send to contacts inside vtiger CRM. It supports both sending
individual messages at given times and mass email actions.

* The emails support a templating system with meta variables as the default system templates does.
* We can see the status of sent and future emails from the contact.
* We support assigning actions to contacts based on account filters.
* We support the status of the email if your email server informs us. We use sendgrid to get this working.

### Design
------

This extension to vtiger CRM consists of 3 new modules and some changes
in the basic behavior of vtiger CRM. The new modules add the ability to
program systematic sending of emails at given intervals, while changes
in the system itself allow clustering, segmentation and selection of
contacts for inclusion in various marketing activities.

![](accionesdigitalesdiseno.png?width=100%)

### Actions

The general idea is to have a module that represents a set of marketing
actions that can be taken. In the current version there is only one type
of action that is sending emails but this module is the basis for future
extensions to other types of actions (document generation, sms,...).

An action has no definition in time, it is only the definition of the
action or email itself. The next module is the place where we will send
the email (action execution) on a certain date. Thus, the actions are a
warehouse of templates that can be used over and over again to different
contacts at different times depending on the goal to achieve. We can
even apply vtiger CRM privacy rules for each user to see only those
templates that should be used and/or segment the actions by sector,
country or whatever is appropriate.

Since it is a normal module of vtiger CRM, we have access to a list view
where you can define filters, search, and add custom fields.

In the detail and edit views we have enhanced the functionality to
permit visualization and edit of the email template:

![](editaction.png?width=100%)
![](viewaction.png?width=100%)


### Programmed Actions

The next module, called Programmed Actions will permit us to execute
marketing actions at a given time.

This module has these fields:

-   **Reference**: a string identifier of the programmed action
-   **Action**: a capture field to the email template (action) to
    execute
-   **Assigned to**
-   **Status**: if the programmed action is set to "**Inactive**" it
    will not be executed when it's time comes
-   **Email From**: defines the email of the sender of the email. The
    possible options are:
    -   _Assigned to_: the email of the
        user assigned to the programmed action
    -   _Created by_: the email of the user
        who created the programmed action
    -   _Assigned to Contact_: the email of
        the user assigned to the contact who will receive the email
    -   _Direct Email_: the email in the
        Direct Email field will be used
-   **Direct Email**: email to use as sender of the email if the **Email
    From** field has a value of Direct
    Email
-   **Execution Date**: date on which the email will be sent if the
    field **Variable Date** is not checked
-   **Variable Date**: if this field is checked the action will be
    launched depending on the reference value in the field **Reference
    Date**, if it is not checked the action will be launched on the date
    indicated by the **Execution Date** field
-   **Reference Date**: this picklist contains all the date fields
    present in the contact module so we can select which one we want to
    use as a reference to launch the action. There is also a special
    date field called **Assigned Date**, this date es dynamic and set at
    the moment in which the contact is related to the action. This
    special field permits us to reuse the action in a very powerful way
    as we can launch the same action for many contacts at different
    times simply based on the moment they are assigned to the action
-   **Offset**: this field will permit us to modify the execution date
    inside a range of days before and after the calculated date when the
    reference date is variable

![](accprog_email.png?width=100%)

![](accprog_date.png?width=100%)

Some **examples** of use cases for this module:

-   Schedule a follow-up email next week, which is done by selecting a
    direct direct execution date
-   Submit a birthday greeting email, selecting the variable date and
    birth date
-   Welcome Email 7 days after creating a contact in the system,
    selecting the variable date, the creation date and an offset of 7
    days
-   Send an email 3 days after a contact is included in the programmed
    action by selecting the variable date, the date of assignment and an
    offset of three days

Contacts can be associated to the programmed action using standard
related lists on the *more information* tab or by using some of the
assignment improvements described below.

### Action Sequencer

This module takes the idea of ​​programmed actions a little further by
allowing us to define groups of actions that will be executed in order.
This facilitates the allocation of contacts to marketing plans or
digital contact policies. So, this module basically allows grouping
actions to schedule them together for execution.

It contains these fields:

-   **Reference**: a string identifier of the sequence
-   **Status**: if the status of the sequence is "Inactive" or
    "Obsolete" on the day of execution, the action will not be run. If
    the value of this picklist is "Between Dates", the sequence will be
    considered Active if the execution takes places between the dates
    defined by the fields **Start Date** and **End Date**
-   **Start Date** and **End Date**: see **Status** above

![](accprog_seq.png?width=100%)

Contacts can be associated to the sequence using standard related lists
on the *more information* tab or by our assignment improvements as
described below.

Programmed actions can be associated to the sequence using standard
related lists on the *more information* tab. The order of execution of
the planned activities will be defined in the programmed actions
themselves, not here in the sequence. The sequence itself is merely an
assistant, a means that allows you to group and assign programmed
actions in batch to contacts. You could accomplish the same thing by
assigning each programmed action one by one to the contacts, the
sequence is much faster and defines a higher level of marketing policy.

Some **examples** of use cases of this module:

-   Holiday Greetings
    -   create a programmed action for each holiday on which you wish to
        send an email, for example, one for New Year, Three Kings,
        Valentine's Day, Father's Day, etc.... Each of these programmed
        actions will have a fixed date of execution upon which they will
        be launched.
    -   create a sequence and associate all the holiday programmed
        actions created
    -   related all the contacts to whom you want to apply this
        marketing campaign to the Sequence
    -   as can be seen we have accomplished the task of assigning many
        actions to many contacts in any easy (vtiger CRM compatible) way
        and also defining a consistent marketing policy to keep in touch
        with our clients
-   Welcome Pack:
    -   the marketing plan which we want to implement consists of a
        first welcome email 2 days after being created in the system,
        another 14 days after that and a last email after 30 days.
    -   create the three programmed actions, they will have a Variable
        Date upon the field **Assignment Date**, the first one will have
        an offset of 3 days, the next one of 14 days and the last one of
        30 days.
    -   create a sequence and associate the three previously defined
        actions
    -   associate the contacts
    -   when a new contact is created in the system we will have to
        related the sequence in his *more information* tab and that will
        be the moment that the "assignment date" will start counting for
        this contact, which will define when the actions will be
        launched
    -   again we see that we have easily assigned three emails to a
        contact with different launch dates

### Assignment optimizations and use
--------------------------------

To facilitate the assignment of contacts to programmed actions and
sequences, we implemented some improvements.

On the contact list view we find a button to mass assign actions and
sequences to contacts. This is an easy and friendly way to quickly
filter and assign actions to many contacts.

![](accprog_selseq.png?width=100%)

In the *More Information* tab of the Contact we have added a related
list of Programmed Actions and Sequences with which we can quickly
assign many of these to any given contact.

We have added a related list on contacts which details a history of
actions taken and still pending. **wishlist** This capability is
somewhat limited. Currently information is stored in an internal table
and you get a list of all historical action in the related list. This
implies that it does not supports paging and can be a problem when you
have sent many emails, it does not supports reports nor filtering. The
solution to all this is to create a new module to store the history.

**wishlist**: We should add the "Load Filter" functionality available in
campaigns to the related lists of programmed actions and sequences in
contacts.

Given the inherent limitation within vtiger CRM that prevents us from
performing filters on fields outside the entity, the previous option
does not allow segmentation upon the account fields associated with the
contact. For example, we cannot make the filters like "contacts whose
company is located in Alicante", this can not be done because we can not
access the account state field from contact filters.

To overcome this limitation we have added the ability to assign actions
to contacts in Reports, where filters can be made as above and much more
advanced. It has the disadvantage of having to run reports for
segmentation but it is the quickest and most effective way to achieve
this goal.

It is MANDATORY that the report contains the column "Contact ID", the
internal ID number of the application, in the end, this is the only
necessary field as it is the only one used to establish the internal
relationship.

![](accprog_report.png?width=100%)

We have enhanced the functionality of the reporting system to support
the production of reports on actions taken.

Each time an email is sent, it is added to the vtiger CRM email module
automatically, thus they can be seen as any normal email from the
contact's *More Information* tab.

We have enhanced the email popup screen used for sending emails with the
selection of templates from the action module.

![](accprog_selemail.png?width=100%)

**wishlist**: we would like to establish a scheduled action from the
email screen. We already allow the selection of the template so,
basically, we lack the programming fields. The problem is that if we
allow modifying the body of the email once captured, this would force us
to create a new action with the body of the email and set the schedule
which is a little overkill. We could block the email body once captured
which is what we will probably end up doing.

If the actions and sequences are disabled, all assignment options
disappear

### Action execution process
------------------------

We have implemented a periodic process that is able to evaluate the list
of pending actions to execute and do them sequentially.

This process provides parameters to control the number of messages sent
every hour or a maximum number of time in which the emails must be sent.
In this way we try to be respectful on server resources and not flood
the email delivery service.

### FAQ
---

**As for the assignment of contacts to a programmed action, if the
action is programmed using "Execution Date" and we assign contacts over
time, what happens?**

The action will be executed on the designated date or, if it has
passed it will execute immediately.
<br>
<hr>
**What happens if a user decides to change the scheduling when there
are related contacts assigned?**

The new settings will not affect already related contacts, they will
only apply to newly assigned ones.
<br>
<hr>
**I see that the Sequences have a start and end date. What happens if
we assign a programmed action with an "Execution date" which is outside
that range of dates on the Sequence? and, what happens if the programmed
actions have a delay and this makes the action fall outside the range on
the Sequence?**

The associations made ​​through sequences will not run. If you
associate a contact directly to the programmed action itself it will be
launched for that contact independently of the association through the
Sequence. You can assign a contact to a programmed action without a
Sequence in the middle, or you can go to a Sequence and associate a
contact so that you are associating the contact to the actions of the
Sequence. Only in this second case will the range of dates on the
Sequence be considered.
<br>
<hr>
**Why not use vtiger CRM workflows?**

Because we need time-based events and workflow events are based on
saving. Because only administrators can define workflows while the
solution implemented here is based on the vtiger CRM Privilege System.
Because workflows do not have a pool of actions from which to start
building programs and sequences.
