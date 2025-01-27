---
title: 'Security Guide Examples'
metadata:
    description: 'Security Guide Examples'
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
        - security
        - manual
        - securityguide
    tag:
        - guide
        - example
---

This chapter discusses the security setup for example organizations and explains what individual users are allowed to do on the CRM system. By far these examples do not include all possibilities to configure the CRM system based on a company needs. However, we believe that the principal functions of the security features are covered so that any user might become capable to create the own setup

===

## Example 1

This simple example shows how access to certain data can be controlled by a group and sharing rules.

Let us assume we have a sales team as shown in Figure: Example Sales Team 1. The Sales Manager is the supervisor for Person 1 and 2 which are members of the group "Team A".

**Figure 2.1. Example Sales Team 1**

![Figure 2.1. Example Sales Team 1](../../02.Role%20Based%20Security%20Basics/sampleteam1.png)

Let us also assume we would like to have the following rules for Leads implemented:

- Person 1 and Person 2 have the permission to create Leads that are owned by Person 1 or Person 2 or both
- If a Lead is owned by a single Person the other Person will have no access privileges to this Lead
- The Sales manager has all access privileges to all Leads.

In order to implement these rules, we have to implement the following setup:

**At Default Organization Sharing Access we set the Global Access Privileges for "Leads" to Private:**

This will cause that users cannot access other users Leads.

**Create one common profile for Person 1 and 2 and the Sales manager:**

We need only one profile, called "Sales" that should include all CRUD privileges for Leads.

**Create two roles:**

We need one role for the Sales manager and one subordinated role for
Person 1 and 2. Both roles are based on the "Sales" profile. Since the
role of the Sales manager is superior to the role of Person 1 and 2 the
Sales manager has all CRUD privileges.

**Create one group of users:**

This group is called "Team A" with the members Person 1 and Person 2.
Now, if Person 1 or Person 2 create a Lead they can assign the owner of
this Lead. If "Team A" is assigned as the owner of the Lead, Person 1,
Person 2 and the Sales manager can access the Lead. When the ownership
is changed to any one member in the group (Person 1 or Person 2) then
only that member and the Sales manager can access the Lead.

 !!! When creating a Lead the CRM system sets the default ownership to the user who creates the data entry automatically. If common access by Person 1 and Person 2 is desired the ownership must be set to "Team A" before saving.

## Example 2

This example shows how access to certain data can be controlled by
groups with sharing rules.

Let us assume we have a sales team as shown in `Figure: Example Sales Team 2`. The Sales Manager is the supervisor for Person 1, 2 and 3, 4 all organized in Team A and B. We also have a sales assistant who supports the sales teams.

**Figure 2.2. Example Sales Team 2**

![Figure: Example Sales Team 2](../../02.Role%20Based%20Security%20Basics/sampleteam2.png)

Let us also assume we would like to have the following rules for Leads implemented:

- Person 1-4 have the permission to create Leads that are owned by any person or by the Team A or B

- Person 1-4 have Read/Write privileges to Leads regardless who owns it.

- The Sales assistant has Read/Write privileges to Leads of the Team A.

- Members of the "Team A" have no CRUD privileges to Accounts and Contacts owned by "Team B" and vice versa.

- The Sales manager has all access privileges to all Leads, Accounts, and Contacts

In order to implement these rules we set the following privileges:

**At Default Organization Sharing Access we set the Global Access Privileges for "Accounts & Contacts" and "Leads" to Private:**

This will cause that users cannot access other users Accounts, Contacts
or Leads. The access to related potentials, tickets, quotes, sales orders, purchase orders, and invoices is also set to private.

**Create one common profile for all Persons and the Sales manager:**

We need only one profile, called "Sales" that should include all CRUD privileges.

**Create three roles:**

We need one role for the Sales manager, one for the Sales assistant and one subordinated role for all Persons. All roles are based on the "Sales" profile.

**Create three group of users:**

We create a group called "Team A" with the members Person 1 and Person 2 and a group called "Team B" with the members Person 3 and Person 4. We create a group called "Assistant" with the user Sales assistant as the only member.

 !!! As described in Section: Custom Access Privileges sharing rules cannot be specified to share data between users. Since we would like to use sharing rules for the Sales assistant we have to create an additional group with only one member.

**Set Custom Access Privileges for Leads:**

From Group "Team A" to Group "Team B" we set the access privilege with
Read/Write permission. From Group "Team B" to Group "Team A" we set the
access privilege with Read/Write permission. From Group "Assistant" to
Group "Team A" we set the access privilege with Read permission.

Now, if any person creates a Lead they can assign the owner of this
Lead. Regardless of the owner, all Persons and the Sales manager have
Read/Write permissions to a Lead. The Sales assistant has Read
permissions to the Leads from "Team A". However, there are no shared
Accounts or Contacts between the two groups or between members of
groups.

## Example 3

This example explains a simple company setup where individual users have limited access to CRM functions.

**Assumptions and requirements**

Consider a very small organization with almost no hierarchical order as shown in `Figure: Small Sample Organization.`

**Figure 2.3. Small Sample Organization**

![Figure: Small Sample Organization](../../02.Role%20Based%20Security%20Basics/smallsampleorg.png)

For this company, we would probably be perfect with two roles, one for
the administrator and one for the company staff. However, we will
introduce 6 roles such as corp_manager, admin. assistant, sales,
service, and accounting in order to be prepared for further company
expansion. We assume a very flat hierarchical order where the sales and
service staff operates on the same information level.

Let us define the following security requirements:

- The head of the company as well as the assistant and the administrator have all privileges.
- The sales team is responsible for all contact information, the service maintains the helpdesk. Both are allowed to browse, to create, to modify or to delete the data.
- Accounting has is done by a third party and has only access to the invoice, purchase order and sales order data.

**CRM System Configuration**

1. set default organization sharing access privileges, so that all user have access to all data
2. set default organization field access privileges, to control the fields shown
3. create profiles, to set privileges
4. create roles, to implement the companies hierarchical order
5. assign the privileges to users

**Default Organisation Sharing Access**

We set the privileges so that all users have access to all data as shown in `Figure: Organisation Sharing Access for Small Company`.

**Figure 2.4. Organization Sharing Access for Small Company**

![Figure: Organization Sharing Access for Small Company](../../02.Role%20Based%20Security%20Basics/orgsharingprivglobalsmall.png)

**Default Organisation Fields Access**

For the purpose of this example, we do change the field access.

**Profiles**

The privileges for each role are based on profiles. We need only 4 profiles:

**Sales Profile**

**Global Privileges:**

All privileges for edit and view any data should be given as shown in `Figure: Global Privileges for Sales`.

**Figure 2.5. Global Privileges for Sales**

![Figure: Global Privileges for Sales](../../02.Role%20Based%20Security%20Basics/globalprivteama.png)

**Tab Privileges:**

We do not restrict the access to the CRM modules for the sales representatives as shown in Figure: Tab Privileges Sales Team.

**Figure 2.6. Tab Privileges Sales Team**

![Figure: Tab Privileges Sales Team](../../02.Role%20Based%20Security%20Basics/tabprivsales.png)

**Standard Privileges:**

We limit some privileges to some modules as shown in Figure: Standard
Privileges Sales Team. The Create/Edit, as well as the Delete privileges for the modules HelpDesk and PurchaseOrder, are revoked.

**Figure 2.7. Standard Privileges Sales Team**

![Figure: Standard Privileges Sales Team](../../02.Role%20Based%20Security%20Basics/standardprivsales.png)

**Field Privileges:**

All privileges are granted.

**Utilities Privileges:**

All export privileges are revoked.

**Service Profile**

The Service Profile is almost identical to the Sales Profile with the following exception:

**Standard Privileges:**

We do not want the service to delete sales related data. Therefore some privileges are revoked as shown in Figure: Standard Privileges Service.

**Figure 2.8. Standard Privileges Service**

![Figure: Standard PrivilegesService](../../02.Role%20Based%20Security%20Basics/standardprivservicesmall.png)

**Accounting Profile**

We would like the external accountant to see the accounting data only.

The Accounting Profile is we need to set up the following privileges:

**Global Privileges:**

The accountant may see any data as allowed by the settings shown in `Figure: Global Privileges Accounting`.

**Figure 2.9. Global Privileges Accounting**

![Figure: Global Privileges Accounting](../../02.Role%20Based%20Security%20Basics/globalprivaccounting.png)

**Tab Privileges:**

We would like to restrict the access to sales related data as shown in `Figure: Tab Privileges Accounting`.

**Figure 2.10. Tab Privileges Accounting**

![Figure: Tab Privileges Accounting]()

Tab Privileges Accounting

**Standard Privileges:**

We do not want the service to delete sales related data. Therefore some privileges are revoked as shown in `Figure: Standard Privileges Accounting`

**Figure 2.11. Standard Privileges Accounting**

![Figure: Standard Privileges Accounting](../../02.Role%20Based%20Security%20Basics/standardprivaccounting.png)

**Corp Head Profile**

The Corp Head Profile has all privileges.

**Administrator Profile**

The administrator profile should have all privileges. A restriction does not make any sense since the administrator has the permission to change the configuration anyway.

**Groups**

We do not need to build any groups.

**Roles**

To have the structure shown in Figure: Small Sample Organization represented by the CRM system 6 roles must be created as shown in `Figure: Sample Role Setup`.

**Figure 2.12. Sample Role Setup**

![Figure: Sample Role Setup](../../02.Role%20Based%20Security%20Basics/samplerolesetupsmall.png)

### Sample Role Setup

Each individual user of the CRM system must be assigned to an appropriate role.

**Assign Privileges to Users**

At the last step, the privileges defined will be assigned to the users as shown in the following table:

**Table 2.1. Privilege Assignment**

<table class="table table-striped">
<tbody>
<tr>
<td>Name</td>
<td>Role</td>
<td>Profile</td>
</tr>
<tr>
<td>Person 1</td>
<td>corp-manager</td>
<td>Corp Head Profile</td>
</tr>
<tr>
<td>Person 1-1</td>
<td>admin</td>
<td>Administrator</td>
</tr>
<tr>
<td>Person 1-2</td>
<td>assistant</td>
<td>Corp Head Profile</td>
</tr>
<tr>
<td>Person 2</td>
<td>sales</td>
<td>Sales Team Profile</td>
</tr>
<tr>
<td>Person 2-1</td>
<td>sales</td>
<td>Sales Team Profile</td>
</tr>
<tr>
<td>Person 2-2</td>
<td>sales</td>
<td>Sales Team Profile</td>
</tr>
<tr>
<td>Person 3</td>
<td>service</td>
<td>Service Profile</td>
</tr>
<tr>
<td>Person 4</td>
<td>accounting</td>
<td>Accounting Profile</td>
</tr>
</tbody>
</table>

## Example 4

This example illustrates a more complex setting, where users have limited access to information owned by others.

**Assumptions and requirements**

Consider a small organization with 14 CRM users as shown in `Figure: Sample Organization`.

**Figure 2.13. Sample Organization**

![Figure: Sample Organization](../../02.Role%20Based%20Security%20Basics/sampleorg.png)

In this environment, there are 11 roles such as corp_manager, admin, m_assistant, sm_manager, s_manager, m_manager, s_assistant, s_team_a, s_team_b, head_service, and service. Accounting, Production, and R&D do not use the CRM system.

The graph structure shows also the role hierarchy based on the tasks within the company.

Let us assume the following:

- A superior inherits the roles of the subordinates
- An individual with the same tasks have the same role

Therefore, as an example, the user with the role head_service (Person 3) inherits the service role. An individual authorized for the role head_service is permitted to perform all of the operations permitted to the individuals Person 3-1 and 3-2 authorized for the role of service. Or, as another example, the head of the sales department with the role s_manager inherits the roles s_assistant, s_team_a, and s_team_b.

In addition, let us define the following security requirements:

- Member of the sales team A are not allowed to see or to modify any data of the sales team B and vice versa.
- Member of the sales team A or B and the service staff are not allowed to export any data.
- The marketing manager with the role m_manager is allowed to see all sales related data but is not allowed to modify those.
- The sales and marketing manager with the role sm_manager is allowed to see all sales and marketing related data.
- The sales manager with the role s_manager is allowed to see and to modify all sales related data of team A and team B.
- The corporate manager with the role corp_manager has all privileges.
- The member of the service team with the role service may see sales related information but are not allowed to modify those. They have all privileges to Helpdesk related functions. They do not have permissions to view or modify Lead related functions nor are they allowed to run any reports.
- Assistants have the same privileges as their superior.
- All CRM users are allowed to create and to modify activities for other users.
- Only the user with the role admin is allowed to access the system settings.

**CRM System Configuration**

To implement these assumptions and requirements at the CRM system we have to:

1. set default organization sharing access privileges, in order to prevent other users to view private data
2. set default organization field access privileges, to control the fields shown
3. create profiles, to set privileges
4. create groups, to combine the privileges of users
5. create roles, to implement the companies hierarchical order
6. assign the privileges to users

**Default Organisation Sharing Access**

The default organization sharing access privileges define the global
privileges for all CRM users. To set up access privileges based on the
hierarchical order it is necessary that the sharing rules get adapted.
Considering the assumptions it is required to modify the default
organization sharing access as shown in Figure: Default Organization
Sharing Access. As it can be seen that almost all privileges are set to
private. We do allow that users can see details and add events to other
users calendar since that is common practice in companies.

**Figure 2.14. Default Organization Sharing Access**

![Figure: Default Organization Sharing Access](../../02.Role%20Based%20Security%20Basics/orgsharingprivglobal.png)

**Note** As a consequence, each individual user is only capable to browse, create, modify or delete the data that has been assigned to:

- this user, or
- to a group where this user is a member

**Default Organisation Fields Access**

For the purpose of this example, there are no restrictions at default organization field access. All fields are available company-wide.

**Profiles**

Profiles define the privileges related to a role. Therefore appropriate
profiles must be created. Based on the assumptions and requirements the
following profiles are needed:

- one profile for the members of team A and B and for the head of the sales department (Sales Team Profile)
- one profile for the Marketing Manager (Marketing Profile)
- one profile for the head of Marketing and Sales (Head Sales Marketing Profile)
- one profile for the service staff (Service Profile)
- one profile for the head of Service (Head Service Profile)
- one profile for the company management (Corp Head Profile)
- one profile for the CRM Administrator (Administrator Profile)

**Note** Due to the requirements in this example, there are fewer profiles than roles.

**Sales Team Profile:**

**Global Privileges:**

All privileges for edit and view any data should be given as shown in `Figure: Global Privileges for Sales Team`. We will restrict the privileges further with the following settings.

**Figure 2.15. Global Privileges for Sales Team**

![Figure: Global Privileges for Sales Team](../../02.Role%20Based%20Security%20Basics/globalprivteama.png)

**Tab Privileges:**

We restrict the access of the sales representatives to the tabs that are necessary to do the sales job as shown in Figure: Tab Privileges Sales Team. The access to reports and purchase orders is revoked since the access to these tabs is a privilege of the superior.

**Figure 2.16. Tab Privileges Sales Team**

![Figure: Tab Privileges Sales Team](../../02.Role%20Based%20Security%20Basics/tabprivsales.png)

**Standard Privileges:**

We also limit some privileges to some modules as shown in `Figure: Standard Privileges Sales Team`. The Create/Edit as well as the Delete privileges for the modules HelpDesk, Products, Vendors, PriceBooks and PurchaseOrder are revoked.

**Figure 2.17. Standard Privileges Sales Team**

![Figure: Standard Privileges Sales Team](../../02.Role%20Based%20Security%20Basics/standardprivteama.png)

**Field Privileges:**

All privileges are granted.

**Utilities Privileges:**

All export privileges are revoked.

**Marketing Profile:**

The Marketing Profile is identical with the Sales Team Profile with one exception:

**Standard Privileges:**

Only the privilege to view any sales related data should be given as shown in `Figure: Standard Privileges Marketing`.

**Figure 2.18. Standard Privileges Marketing**

![Figure: Standard Privileges Marketing](../../02.Role%20Based%20Security%20Basics/standardprivmarketing.png)

**Head Sales Marketing Profile:**

The Head Marketing Sales Profile is identical with the Sales Team Profile with one exception:

**Tab Privileges:**

The head of this department has the privilege to access the report and
the purchase order functions. Therefore the Tab Privileges must be set
as shown in `Figure 2.19, Tab Privileges Head Sales Marketing`.

**Figure 2.19. Tab Privileges Head Sales Marketing**

![Figure: Tab Privileges Head Sales Marketing](../../02.Role%20Based%20Security%20Basics/tabprivheads.png)

**Utility Privileges:**

In addition, we grand all export privileges at the Utility Privilege configuration.

**Service Profile**

The service privileges are focused on helpdesk and related contact information.

**Global Privileges:**

All privileges are granted

**Tab Privileges:**

All tabs related to the service are allowed as shown in `Figure: Tab Privileges Service`.

**Figure 2.20. Tab Privileges Service**

![Figure: Tab Privileges Service](../../02.Role%20Based%20Security%20Basics/tabprivservice.png)

**Standard Privileges:**

We do not want the service to create, edit or delete sales related data.

Therefore some privileges are revoked as shown in `Figure: Standard Privileges Service`.

**Figure 2.21. Standard Privileges Service**

![Figure: Standard Privileges Service](../../02.Role%20Based%20Security%20Basics/standardprivservice.png)

**Field Privileges:**

All privileges are granted.

**Utility Privileges:**

All privileges are revoked.

**Head Service Profile**

The profile for the head of the department is almost identical to the Service Profile. However, we do allow administrative functions.

**Tab Privileges:**

In addition to the Service Profile, we allow report functions as shown in `Figure: Tab Privileges Head Service`.

**Figure 2.22. Tab Privileges Head Service**

![Figure: Tab Privileges Service](../../02.Role%20Based%20Security%20Basics/tabprivheadservice.png)

**Utility Privileges:**

All privileges are granted.

**Corp Head Profile**

The Corp Head Profile has all privileges.

**Administrator Profile**

The administrator profile should have all privileges. A restriction does not make any sense since the administrator has permission to change any configuration.

**Groups**

Since we have set the default organization sharing privileges to private we must create groups to give others access to information which has to be shared. To meet the assumptions and requirements the following groups must be created:

**Sales Team A:**

This group has two members who can be identified by their user name. We will call this group "Team A".

**Sales Team B:**

This group has two members who can be identified by their user name. We will call this group "Team B".

**Head of Sales:**

To give the sales department manager and the assistant access to the
data of the sales teams A and B we will create a new group, called "Head Sales" with the member groups "Team A" and "Team B".

**Tip** You may consider building the "Head Sales" group by selecting
the individual sales team persons as members of this group. We recommend not to do this. While it functioning well it is much harder to maintain when the members of the sales teams change in the future.  
Sales and Marketing:

In order to give the head of the marketing and sales department the
privilege to browse the data of the sales and marketing teams, we will
create a new group, called "Sales and Marketing" with the member roles
"Head Sales" and "Marketing".

**Note** We chose to introduce a group of roles for this example.

**Service:**

The service group has two members who can be identified by their user name. We will call this group "Service Team".

**Roles**

To have the structure shown in Figure: Sample Organization represented by the CRM system 11 roles must be created as shown in `Figure: Sample Role Setup`.

**Figure 2.23. Sample Role Setup**

![Figure: Tab Privileges Service](../../02.Role%20Based%20Security%20Basics/samplerolesetup.png)

Each individual user of the CRM system must be assigned to an appropriate role.

**Assign Privileges to Users**

At the last step, the privileges defined will be assigned to the users as shown in the following table:

**Table 2.2. Privilege Assignment**  

<table class="table table-striped">
<thead>
<tr class="header">
<th>Name</th>
<th>Role</th>
<th>Profile</th>
<th>Group Membership</th>
</tr>
</thead>
<tbody>
<tr>
<td>Person 1</td>
<td>corp-manager</td>
<td>Corp Head Profile</td>
<td>none</td>
</tr>
<tr>
<td>Person 1-1</td>
<td>admin</td>
<td>Administrator</td>
<td>none</td>
</tr>
<tr>
<td>Person 1-2</td>
<td>m-assistant</td>
<td>Corp Head Profile</td>
<td>none</td>
</tr>
<tr>
<td>Person 2</td>
<td>sm_manager</td>
<td>Head Sales Marketing Profile</td>
<td>Sales and Marketing</td>
</tr>
<tr>
<td>Person 2-1</td>
<td>s-manager</td>
<td>Sales Team Profile</td>
<td>Head Sales</td>
</tr>
<tr>
<td>Person 2-2</td>
<td>m-manager</td>
<td>Marketing Profile</td>
<td>none</td>
</tr>
<tr>
<td>Person 2-1-1</td>
<td>s_assistant</td>
<td>Sales Team Profile</td>
<td>Head Sales</td>
</tr>
<tr>
<td>Person 2-1-2</td>
<td>s_team_a</td>
<td>Sales Team Profile</td>
<td>Sales Team A</td>
</tr>
<tr>
<td>Person 2-1-3</td>
<td>s_team_a</td>
<td>Sales Team Profile</td>
<td>Sales Team A</td>
</tr>
<tr>
<td>Person 2-1-4</td>
<td>s_team_b</td>
<td>Sales Team Profile</td>
<td>Sales Team B</td>
</tr>
<tr>
<td>Person 2-1-5</td>
<td>s_team_b</td>
<td>Sales Team Profile</td>
<td>Sales Team B</td>
</tr>
<tr>
<td>Person 3</td>
<td>head_service</td>
<td>Head Service Profile</td>
<td>Service</td>
</tr>
<tr>
<td>Person 3-1</td>
<td>service</td>
<td>Service Profile</td>
<td>Service</td>
</tr>
<tr>
<td>Person 3-2</td>
<td>service</td>
<td>Service Profile</td>
<td>Service</td>
</tr>
</tbody>
</table>

------------------------------------------------------------------------

[Next](../../03.Summarized%20Rules/) | Summarized Rules

------------------------------------------------------------------------

© 2006 crm-now
