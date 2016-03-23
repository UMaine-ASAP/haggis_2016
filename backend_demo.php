<?php

// ALL ROUTING NEEDS TO BE DONE FROM THE ROOT DIRECTORY TO ENSURE THE CURRENT WORKING DIRECTORY REMAINS STABLE. THIS CAN BE REPLACED WITH AN ENVIORNMENT VARIABLE IF NEEDED.
require_once getcwd() . "/models/project.php";

// Access a user
$user = new User(1); // This gets the user with ID equal to 1
echo $user->firstName . " " . $user->lastName . " is a user with an email of " . $user->email . "<br><br>";

// Change the users data
$user->firstName = "Fred"; // Changes the LOCAL copy, not the database entry.
$user->Save(); // Preforms the write to the database, ensuring the change is permenant.

echo $user->firstName . " " . $user->lastName . " is a user with an email of " . $user->email . "<br><br>";

// Change the users data back for demo sake
$user->firstName = "Bob"; // Changes the LOCAL copy, not the database entry.
$user->Save(); // Preforms the write to the database, ensuring the change is permenant.

// Access a class
$class = new Period(1); // This gets the class with ID equal to 1. NOTE that the name of the class is "Period", not "Class"

// Add a user to a class
$class->AddUser($user->userID,1); // Adds a user with the specified role

// Get all users of a class
$users = $class->GetUsers();
print_r($users); echo "<br><br>";

// Access an assignment
$assignment = new Assignment(1); // This gets the assignment with ID equal to 1

// Add a class to the assignment
$assignment->AddClass($class->classID);

// Get the first class of an assignment
$tempclass = $assignment->GetClasses()[0];

// Get the users of the temp class
print_r($tempclass->GetUsers()); echo "<br><br>"; // As you can see, you can traverse the objects easily to get from one to another

// Remove a user from the temp class
$tempclass->RemoveUser($user->userID);


// Create new users by passing zero as the ID. This will create a new user that can have fields added.
$u = new User(0);
$u->firstName = "Dummy";
$u->lastName = "Person";
$u->middleInitial = "-";
$u->Save();

// Check the newly created user's ID
echo "ID = " . $u->userID; echo "<br><br>";

// Delete the created user
$u->Delete();

// The rest of the classes work the same way. Each class EXACTLY matches how the database was setup. If a database mapping is named 'project_assignment' then the Project class has the functions "AddAssignment", "GetAssignments", and "RemoveAssignment". All objects can be created and deleted in the same way as the example. Simply use the null index of 0 to create a new entry of an object. It will be immediately added to the database unless you delete it.

?>