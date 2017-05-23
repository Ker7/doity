<!DOCTYPE html>
<html>
  <head>
    <title>Field {{ $field->id }}</title>
  </head>
  <body>
    <h1>Field ID: {{ $field->id }}</h1>
    <ul>
      <li>Name: {{ $field->name }}</li>
      <li>Author: {{ $field->author_id }}</li>
      <li>Created at: {{ $field->created_at }}</li>
    </ul>
  </body>
</html>