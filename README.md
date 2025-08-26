i. User Authentication (Entry Point)

User/login.blade.php → User logs in.

User/register.blade.php → New users register.

After login/registration → Redirects to User/dashboard.blade.php.

ii.Layout Setup

layouts/app.blade.php → The base layout.

Contains common UI (header, navbar, footer, sidebar).

All other views extend this layout with @extends('layouts.app').

iii. CRUD Modules Workflow

Each module (students, teachers, subjects, attendances) follows a similar workflow:

1.Students Module

students/index.blade.php

Displays a list of students.

Contains actions → Create, Edit, Delete.

students/create.blade.php

Form to add a new student.

On submit → stored in database → redirects back to index.

students/edit.blade.php

Form to update an existing student’s details.

On submit → updates record → redirects back to index.

Same pattern is applied to:

2.Teachers (teachers/index, teachers/create, teachers/edit).

3.Subjects (subjects/index, subjects/create, subjects/edit).

4.Attendances (attendances/index, attendances/create, attendances/edit).

