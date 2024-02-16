<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Display JSON Data</title>
<style>
  table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
  }
  th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }
  th {
    background-color: #f2f2f2;
  }
  button {
    margin-bottom: 10px;
  }
</style>
</head>
<body>

<button id="create-btn">Create Data</button>

<table id="data-table">
  <thead>
    <tr>
      <th>Name</th>
      <th>Age</th>
      <th>City</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="data-body">
  </tbody>
</table>

<script>
document.getElementById('create-btn').addEventListener('click', createData);

function createData() {
  // Redirect the user to create.php
  window.location.href = 'create.php';
}

// Function to delete data
function deleteData(id) {
  // Send an AJAX request to delete.php with the ID to delete data from the JSON file and database
  fetch(`delete.php?id=${id}`, {
    method: 'DELETE'
  })
  .then(response => {
    if (response.ok) {
      // Reload the page to reflect the changes
      window.location.reload();
    } else {
      throw new Error('Failed to delete data');
    }
  })
  .catch(error => console.error('Error deleting data:', error));
}

fetch('json_data/Student_json_data.json')
  .then(response => response.json())
  .then(data => {
    const tableBody = document.getElementById('data-body');
    data.forEach(person => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${person.Name}</td>
        <td>${person.Age}</td>
        <td>${person.City}</td>
        <td>
          <button class="update-btn" data-id="${person.ID}">Update</button>
          <button class="delete-btn" data-id="${person.ID}">Delete</button>
        </td>
      `;
      tableBody.appendChild(row);
    });

    // Add event listener for update buttons
    const updateButtons = document.querySelectorAll('.update-btn');
    updateButtons.forEach(button => {
      button.addEventListener('click', () => updateData(button.dataset.id));
    });

    // Add event listener for delete buttons
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
      button.addEventListener('click', () => deleteData(button.dataset.id));
    });
  })
  .catch(error => console.error('Error fetching data:', error));

function updateData(id) {
  // Redirect the user to update.php with the user ID as parameter
  window.location.href = `update_json.php?id=${id}`;
}

</script>

</body>
</html>
