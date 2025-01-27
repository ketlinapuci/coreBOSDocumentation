---
title: 'coreBOS development environment'
metadata:
    description: 'How to set up a coreBOS development environment: git workflow'
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
        - installation
        - development
        - contribute
    tag:
        - install
        - guidelines
---

## How to set up a coreBOS development environment: git workflow

This is a quick guide which contains all the tools you'll need to configure your coreBOS development environment. Along the way, we will offer some advice to keep in mind as you actually set up your development environment.

===

The purpose is to help everyone have an empowering and welcoming first experience as they start contributing to the **coreBOS Open Source project!**

- **What you’ll learn**
  - How to access the code of a coreBOS install.
  - How to access this coreBOS install via web services.
  - How to execute all the unit tests accessing the demo data.

<span></span>

- **What you’ll need**
  - **LAMP** (Linux, Apache, MySQL, PHP) stack.
  - **Code editor**, anyone you prefer and work with.
  - And obviously, you need to have **Git** installed because coreBOS is a git-based open source project. That means that contributing to the project is basically the same as for any other git-based project.

## Let’s get started, shall we?

The real goal of this quick guide is to help you contribute back to the
coreBOS project, so in order to do that, there are two basic ways to get
the repository:

- Firstly, the example of many coreBOS developers on the team. They have permission to push to the coreBOS repository. That means they can download directly from the [tsolucio/corebos](https://github.com/tsolucio/corebos) URL.
- If you don’t have that permission, then you have to **fork** the project on your GitHub account. You can do everything you want in your forked repository, but in the end, if you want to share the code, you have to push it to your fork and then emit a pull request. That’s the path we are going to demonstrate.

## Forking the GitHub repository

Forking a repository is really straightforward and in most cases just a two-step process:

- Make sure you are logged into GitHub with your account.
- Head over to the [tsolucio/corebos](https://github.com/tsolucio/corebos) Github repository. This is the place where coreBOS lives.
- Click the **Fork** button on the upper right-hand side of the repository’s page.

It is nice to share some love and click on the **Star** too!!

**That’s it!** You now have a copy of the original repository in your
GitHub account. This fork serves as your personal public repository, no
other developers are allowed to push to it, unless you allow them to,
but anyone can pull changes from it.

## Clone your fork on your local development computer

Now that you have a copy of the original repository in your GitHub
account, you have to clone the repository down to your local system
using `git clone`. This way you can make changes to the forked
repository in your GitHub account.

Go to the root of your Apache web server and start working from there.

The standard `clone` command creates a local git repository from your
remote fork on GitHub.

`git clone https://github.com/USERNAME/corebos cbdevel`

What are we basically doing is telling Git to connect to this
repository, which is our coreBOS open-source repository and clone it. If
we don’t add anything else it will automatically create a corebos
directory for us and push in all the code to that directory. We are
going to add our own directory here: **cbdevel**. So it will create this
cbdevel directory and throw in all the code. Let's jump into this
directory,

`cd cbdevel`

and we have here the coreBOS code, just downloaded with the latest version.

In this directory, we can launch a `git log`, for example, and it will
show us all the commits that have been made till now.

## What else can we do?

display the state of the working directory and the staging area

`git status`

Right now, there are no changes, so everything is good.

`git show --summary`

It will show the last applied commit; the last code change that coreBOS got.

So, okay, this is not something we could have done downloading the zip
file. The real important thing is that this directory is controlled by
git. Any changes we make, to any file, will automatically be noticed and
controlled by GIT. This whole directory is connected to the GitHub
repository. If anything changes there we can easily apply those changes
locally (pull).

For example, if we hit

`vi index.php`

and add some lines in this file, if we do the `git status` again it will
say: **Hey, you modified some files!** So we know that locally this
file is changed.

If we ask git exactly what changes have been made there:

`git diff index.php`

It will also show us that this bunch of new lines have been entered there.

If we want to undo this change, we can just check out the version:

`git checkout index.php`

And if we type `vi index.php` we can see that now we are back to where
we were before and there are no new lines on the index.php. And if we do
`git status` again everything is clean.

So basically what we are trying to say here is that this is not just a
download of the coreBOS code. It’s alive and controlled by git. Git
knows what’s happening in this directory. It also knows what is
happening in the parent directory where it came from:

`git remote -v`

This shows that this directory is connected to the real repository
online. So once it changes we can quickly update and know what’s going
on. We will see a little bit more about that when we update.

## Permission System

Once we have set up all the files of the coreBOS repository, the next
thing we have to do is control the permissions. We are downloading in
the root of the Apache directory, that means that the Apache user must
have access to the install, otherwise, it won’t be able to read the
files, nor modify the ones it needs to inside the directory. We have to
grant permission to `www-data`, which is, in this case, my apache user.
Each apache installed will have a different (or not) apache user.

When you clone like this, usually, especially on Linux, the permissions
will already be granted to the user and the group. The user is the user
we are working with, the one we are cloning with right now. The group is
what we are going to use to give access to the Apache server so both the
group and the user can do whatever they want inside the directory.

`chgrp -R www-data ../cbdevel/`

- `www-data` is the Apache user, and we assign it to cbdevel directory
- `-R` flag means it will recursively go down all the directory tree and sign all the files to this group.

Now our user is the owner of all files (so we can edit them normally
with our user) and the webserver user is the group (so it can write the
files it needs to write to work)

**This marks the end of our first step.**

We now have the code and can import the project into our code editor. So
we can access all the files in that directory and start modifying them.

The next step would be [installing the project](../02.installation) as we would normally do.

At this point, we are already set up to be able to modify coreBOS, study
the code and be able to do whatever we need to. A few more steps to get
it right, but that’s the bulk of the work to be done.

Basically, it is a total normal install, exactly what you would find if
you did a ZIP download and copied it into a new directory. The only
difference here is that if we list all the files in this new directory,
including the hidden ones we can see that we have a hidden directory
named `.git`. This git directory will not come down if you do a zip
download package of the code. The `.git` directory is the only
difference and is where everything gets controlled by git. That’s why
the install is the same and really nothing changes.

As soon as the installation is complete, ask git about what it has to
say of the installation process. You can do so by typing:

`git status`

We can see that the install directories have been deleted. Notice that 2
directories and 1 file have appeared which Git doesn't know what they
are. Now we should restore these files.

- move the renamed install directory and file back to their original place:
  - the directory **"install"** and the file **"install.php"** will be renamed after the installation. Rename them back to their original name:

```shell
mv 8432658395801x3fab13af3.42704102install/ install
mv 8432658395801x3fab13af3.42704102install.php.txt install.php
```

Notice that this is a security measure because you don’t want these to
be able to be read and execute when we are in production. In fact, if it
was a production install we should actually have renamed and deleted
these files and then committed the change. In this case, we need them
around because we need to modify them as we are in the developer
version.

We can also see that the **config.inc.php** and **tabdata.php** files
have been modified with all the information for the new database access
and configuration.

These two files are different on almost all coreBOS installs. They start
(mostly) empty on the main repository and get modified when you install
the application and when you install or deactivate modules. These
changes are specific to each install, so if we make any modification to
them we will be causing git merge conflicts for everyone and those
conflicts will mostly be resolved by keeping their particular version.
Ideally, we could have not included them in the distribution but it is
too late for that now.

The recommended procedure to manage these files is to version them in
the main repository of the install. As explained above, each coreBOS
install should have its own repository and pull in changes from the main
coreBOS repository. So you will version the **config.inc.php** and
**tabdata.php** files in the repository of the install. This way you
have these important files controlled for each install and coreBOS main
repository will not modify them. If you install a new module, your tab
data will change and you can commit it to the local repository.
Obviously, this repository should not be publicly accessible.

Now, this brings us to one problem. When a developer needs to work on a
project, and he clones the install locally, he needs to modify
config.inc.php to adapt it to his development environment, this change
could lead to a mistake where you commit the file and break the
production installation while sharing your password with everyone. To
avoid this, config.inc.php includes the file config-dev.inc.php at the
end of the script. This file is ignored by the `.gitignore` file so it
will never be committed and will only be on each local development
machine that needs it. This file will permit us to override any settings
in config.inc.php without having to modify that file.

The **config-dev.inc.php** template I use is this one:

```php
<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
$site_URL = 'http://localhost/coreBOSwork';
 
// root directory path
$root_directory = __DIR__.'/';
 
$dbconfig['db_name'] = 'database name';
$dbconfig['db_username'] = 'database user';
$dbconfig['db_password'] = 'database password';
 
$dbconfig['db_server'] = 'localhost';
$dbconfig['db_hostname'] = $dbconfig['db_server'].$dbconfig['db_port'];
$hostname=$dbconfig['db_hostname'];
$LOG4PHP_DEBUG = true;
//$default_language = 'en_us';
?>
```

Another situation that appears from time to time is when you don't have
a private repository for your install, you just clone the main
repository from GitHub, install it, and work there. In this case, both
config.inc.php and tabdata.php appear in the "git status" commands and
are always there as you can't commit them. You have two alternatives:

- one is just ignoring them, it really isn't that much noise and you get used to seeing them there
- the other is to tell git to not show them to you with the command:

`git update-index --skip-worktree config.inc.php tabdata.php`

 !! Please note that these two files must **NEVER** be in any commit you make on the main project. Pull requests that contain any modifications to these files won't be accepted.

## How to execute all the unit tests accessing the demo data?

In the cbdevel directory, inside the `build` directory, we have a
directory named **coreBOSTests**. This coreBOSTests directory is empty
and we need to download all the unit tests for coreBOS there. The
comfortable way of doing this is by following these steps:

- Delete the coreBOSTests directory

`rmdir coreBOSTests`

- Do a fork of the coreBOSTests repository and then clone it to our local repository.

`git clone https://github.com/USERNAME/coreBOSTests coreBOSTests`

What we just did now was deleting the coreBOSTests directory that comes
natively with coreBOS and download the exact project of Tests from GitHub.

Again as we did with the cbdevel directory, we should change the
permissions for the coreBOSTests

`chgrp -R www-data coreBOSTests`

Now we have the Test environment installed in its own repository.

Now, we need to be able to login to the coreBOS install with demo data.
We need to set up the data, so we can actually work with unit tests. In
order to achieve that, we have to recover the database that is on the
coreBOSTests project. So in the **coreBOSTests Project**, in the
database directory, we have the **coreBOSTests.sql** database. This is a
fully valid coreBOS install with test data.

Now we have to delete the coreBOS database cbdevel, that we created
during the install. After dropping it, create a new database `cbdevel`
(**utf-8 general ci**). Right now, our new database is empty. We have to
fill it up with the information inside **coreBOSTests/database**. Here
is the **coreBOSTests.sql** database, so we load this information into
the database that we have just created.

`mysql -u root -p cbdevel < coreBOSTests.sql`

The idea is that you install coreBOS simply to get the `config file`. We
could have manually set up the config.inc.php file and directly recover
this database. In this way, we wouldn’t really need to install it, but
the install process is rather easy and is always good to install from
time to time, so we catch errors that may have been introduced into that
process. Anyways both paths are perfectly valid.

## User set up

If we notice the coreBOS install has 10 users, and if you see at the
user privileges directory:

`ls -l user_privileges`

We will see that there is only one, which is the admin user. So we need
the other ones to be able to log in.

```shell
# takes into consideration the new users in the database
build/HelperScripts/createuserfiles 
```

If everything went correctly now when we type

`ls -l user_privileges`

We should have a whole bunch of files in the directory.

We have to go into the `user_privileges` directory and change all of
these files’ permission to the group `www-data`, so they can be
regenerated by the application if necessary.

## coreBOS Updater

There is a lot of information about this fundamental tool in the coreBOS
lifecycle, but for the purpose of this tutorial, suffice to say that,
when we recover the database we must always go to the [coreBOS Updater](../../10.developer-guide/04.development_framework/11.develtutorials/08.corebosupdater), load the updates and apply them all.

## How to access this coreBOS install via web services?

On the tsolucio repository, you can find the
[coreBOSwsDevelopment](https://github.com/tsolucio/coreBOSwsDevelopment)
application. This application is a test and development platform where
you can access any coreBOS that you have permission to access and you
can launch web services query and do a whole bunch of test coding and
things like that. Again at the root of our apache webserver, we do a
clone of our already forked web services repository. We are going to
name the directory wsdevel.

`git clone https://github.com/USERNAME/coreBOSwsDevelopment wsdevel`

This repository doesn’t need anything else to be set. We don’t have to change the permissions.

We can access our web service interface by typing **localhost/wsdevel** in our browser.

It asks us where our install is and we can access it either via password
or access key. After we are done with that, we can launch web service
queries and get access to all the information.

## Ready to start collaborating!

Now we are actually finished with the coreBOS development application.

We have everything we need: the test data, access to the code, we have
access with all the users for us to start working and committing pull requests.

For every change you want to implement you start from the master branch,
which is the default branch, you create a new branch, develop want you
need, with as many commits and time as you need, when you have it
finished, tested and all committed you push it to Github.

Now go to GitHub and you will see the option to create a Pull Request
from your branch. I will get notified, I will study your changes,
comment, maybe ask you to make some more changes for which you will need
to check out your branch again and add them there when you push them,
GitHub will update the PR. I will finally accept your changes and
incorporate them into the main master branch.

Once that happens you update your fork and your master branch gets the
changes so your branch is not needed anymore and you can delete it.

Then you start all over again.

Obviously, you can have as many branches as you need at the same time,
developing many features in parallel.

If you need to update your branch with the latest changes from the
mainstream master branch you would launch a merge (or rebase) command.
When you launch the `git branch -b` command to create a new branch that
branch starts from the state the master branch is in at that moment.
Let's suppose that it takes you a few days to finish your feature and in
that time coreBOS has added a few more commits. You need to add these
changes to your branch before pushing, to do that we would execute:

```shell
git checkout master (just to make sure)
git pull upstream master  (we get the new changes)
git checkout new_feature
git merge master
# Fix conflicts if any appear
```

The new commits are now also in your branch.

## Conflicts: Mergetool

When doing the pull and merge it is possible that we run into some conflicts. That means that we are changing a file that has changed in the main repository. It is our responsibility to fix that because we are the ones who know what our changes are about. To make this process easier git has a syntax that helps us, but I usually configure [meld merge tool](https://meldmerge.org/) like this:

`git config --global merge.tool meld`

which gives us a nice graphical interface to resolve conflicts.

 !!! **Congratulations!**

Now, go forth and **build**!

What if you get stuck? That’s perfectly fine.

- The best place to contact the developer community is on our [Gitter chat group](https://gitter.im/corebos/discuss).
- The blog is mostly developer-oriented and there is a lot of information here in the documentation site.
- You can ask in the [forum](https://discussions.corebos.org/).

Don't hesitate to get in touch, we are a **really friendly and helpful community**.

**Welcome to the coreBOS development team!**

**We look forward to seeing your code!**

[plugin:youtube](https://www.youtube.com/watch?v=579A0MjOeIE)