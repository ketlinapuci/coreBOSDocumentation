---
title: 'How to rename or delete a field'
metadata:
    description: 'How to rename or delete a field'
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
        - development 
        - field
    tag:
        - renamedelete
---

**Procedure**

- manually change all the places where the field is being used in the code
- manually change all the places where the field is being used in the database
- change the field name or delete the field

**Explanation and Guidelines**

This is a very delicate operation because the field you want to delete or rename can be in use in many places throughout the application. For example, it can be used in filters, reports, workflows, or business maps just to name a few.

All of those places where the field is being used must be updated depending on the goal of this task.

coreBOS will try to help by blocking the action and showing a list of places it can find the field so you can proceed to adapt the functionality.

Besides the work that coreBOS does, we must also review the code. Launch a global search in the code to see if the field we are changing/deleting is being used somewhere and modify that code accordingly. Normally this will be only in the main module class file, where the list fields, entity link fields, and other special fields are defined, but you must search the rest of the code in case there is any special usage of the field somewhere. Obviously, if the field belongs to a custom module your context of the field will help you decide the steps to take.

This next code is a changeset that tries to delete the phone field from the Contacts module.

```php
class deleting extends cbupdaterWorker {
	public function applyChange() {
		if ($this->hasError()) {
			$this->sendError();
		}
		if ($this->isApplied()) {
			$this->sendMsg('Changeset '.get_class($this).' already applied!');
		} else {
			$module = Vtiger_Module::getInstance('Contacts');
			$field = Vtiger_Field::getInstance('phone', $module);
			$rdo = false;
			if ($field) {
				$rdo = $field->delete();
			}
			if ($rdo) {
				$this->sendMsg('Changeset '.get_class($this).' applied!');
				$this->markApplied(false);
			} else {
				$this->sendMsgError('Changeset '.get_class($this).' WAS NOT applied!');
			}
		}
		$this->finishExecution();
	}
}
```

and this is what the output looks like

![](changesetdeletefield.png)

As you can see, coreBOS lists the places where it found the field so you can adapt them and apply the changeset again.

Updating a field name looks very similar.

```php
class testing extends cbupdaterWorker {
	public function applyChange() {
		if ($this->hasError()) {
			$this->sendError();
		}
		if ($this->isApplied()) {
			$this->sendMsg('Changeset '.get_class($this).' already applied!');
		} else {
			$newname = 'changephone';
			$module = Vtiger_Module::getInstance('Contacts');
			$field = Vtiger_Field::getInstance('phone', $module);
			if ($field) {
				$field->name = $newname;
				$fieldid = $field->save();
			}
			$fieldname=getSingleFieldValue('vtiger_field', 'fieldname', 'fieldid', $fieldid);
			if ($fieldname==$newname) {
				$this->sendMsg('Changeset '.get_class($this).' applied!');
				$this->markApplied(false);
			} else {
				$this->sendMsgError('Changeset '.get_class($this).' WAS NOT applied!');
			}
		}
		$this->finishExecution();
	}
}
```

![](changesetupdatefield.png)

So, in short, the steps are:

- change all the places where the field is being used both in the code and in the database
- change the field name or delete the field

The warnings that coreBOS gives us when trying to make the change will take us a long way but there are still some other things that we need to consider.

**Filters and Reports**

The fields are saved in vtiger CRM extended column format, like this:

'vtiger\_activity:dtstart:dtstart:cbCalendar\_Start\_Date\_and\_Time:DT'

so if we want to change the dtstart field name we have to change only the second entry, not both.

'vtiger\_activity:dtstart:**change\_this\_one**:cbCalendar\_Start\_Date\_and\_Time:DT'

**Picklists Fields**

Picklists fields (uitype 15 and 16) create tables to save the values they contain. These table names and columns inside the table are based on the field name, so when we change this field name we must also change the tables accordingly.

One approach is to directly create a new picklist for the new field name, leaving the previous picklist unlinked and abandoned in the database. In this case, you will lose the profile/role settings so you can only do that if you are sure there are none set. This is not an issue for uitype 16 (non-role based picklists)

If you are deleting the field you can either leave the table there or delete it. The correct thing to do is to delete the table and its row in the vtiger\_picklist table.

In order to use the existing table and change the picklist tables, you would have to take the next steps. Let's suppose we are changing the *assetstatus* field in assets to *aststatus*.

- change the table name: vtiger\_assetstatus convert into vtiger\_aststatus
- change the sequence table name: vtiger\_assetstatus\_seq convert into vtiger\_aststatus\_seq
- change column names:
  - vtiger\_assetstatus.assetstatusid to vtiger\_aststatus.aststatusid
  - vtiger\_assetstatus.assetstatus to vtiger\_aststatus.aststatus
- change vtiger\_picklist.name from assetstatus to aststatus

**Column name change**

coreBOS is prepared to have fields with a different field and column name, but it is much better if they are the same. If you can, set the column name to the same value as the field name and alter the column in the associated database table.

Be aware that changing the column name, much like the field name, has its own set of issues. For example, the list view filters, reports and workflow conditions use this column name directly so you will have to change those wherever they are used.

My recommendation would be to leave the column name as it is. If you find anywhere that the application does not manage this correctly, we fix the application to do it correctly.

## Automating the changes

I dedicating some time to creating a function that could help us automate the necessary changes. The idea is that if the application can find the usage of the field in some places, why not have it change them for us directly?

It turns out that there are very few places where this can be done safely. For example, the table its4you\_calendar\_modulestatus holds a relation of the field that will be used to show the different status of a module on the calendar. In other words, which field will be "held" or "pending" in the calendar context. This table has a module and a field column, so we can directly change the value in the field column with the new name. But, the majority of places have some sort of codification.

Workflows: the "test" column contains a serialized text of the workflow conditions with the field inside. We would have to unserialize, find the field, change it, and serialize again. A lot of work and very error-prone.

Filters and Reports: the fields are saved in vtiger CRM extended column format, like this:

'vtiger\_activity:dtstart:dtstart:cbCalendar\_Start\_Date\_and\_Time:DT'

so if we want to change the dtstart field we have to change only the second entry, not both. Again, error-prone

Message Templates: the field is embedded inside the body or subject of the message, we would need to study the merging code to get a correct regular expression that would change just the field and nothing else. Again, error-prone.

Due to all that, and that I think this operation is something that we will do very rarely, and when we do, it will be on a small set of fields or on a set of fields that aren't really in use yet (at the start of a project) so most actions will just work. I decided not to dedicate more time to it.

So, automating the changes can be done, but it is probably easier to just create the changeset to update the fields, launch it various times and fix all the places that coreBOS finds until it can be changed.
