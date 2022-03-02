Condition Expression Business Mapping
=====================================

This mapping permits us to evaluate an expression in the context of the
application and get the result to decide subsequent actions. It accepts
two formats, one is a direct expression from the workflow expression
engine and the other is a function expression that can be called from
inside the system. The function parameters will be changed to the
current record values if they exist.

     <map>
      <expression>uppercase('this string')</expression>
     </map>

     <map>
      <expression>accountname</expression>
     </map>

     <map>
      <expression>employees + 10</expression>
     </map>

     <map>
      <expression>if employees > 10 then 'true' else 'false' end</expression>
     </map>

    <map>
      <function>
       <name>isPermitted</name>
       <parameters>
        <parameter>Accounts</parameter>
        <parameter>CreateView</parameter>
        <parameter>record_id</parameter>
       </parameters>
      </function>
     </map>

the isPermitted mapping above will be converted into:

    isPermitted('Accounts','CreateView','74');

Additional Information
----------------------

-   [Forum thread](http://discussions.corebos.org/thread-642.html)