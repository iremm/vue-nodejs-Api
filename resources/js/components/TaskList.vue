<template>
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>User Management</h2>
      <button @click="openAddUserModal" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Add New User
      </button>
    </div>
    <table class="table mt-5">
      <thead>
        <tr>
          <th>Name</th>
          <th>Surname</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.firstname }}</td>
          <td>{{ user.lastname }}</td>
          <td>
            <button @click="deleteUser(user.id)" class="btn btn-danger btn-sm">Delete</button>
            <button @click="openUpdateUserModal(user)" class="btn btn-info btn-sm">Update</button>
          </td>
        </tr> 
      </tbody>
    </table>

    <div class="modal" id="addUserModal">
      <!-- Modal content -->
      <div class="modal-content">
        <span class="close" @click="closeAddUserModal">&times;</span>
        <h3>Add New User</h3>
        <!-- Form for adding new user -->
        <form @submit.prevent="addNewUser">
          <input type="text" v-model="newUser.firstname" class="form-control mb-2" placeholder="First Name">
          <input type="text" v-model="newUser.lastname" class="form-control mb-2" placeholder="Last Name">
          <button type="submit" class="btn btn-primary">Add User</button>
        </form>
      </div>
    </div>

    <!-- Update User Modal -->
    <div class="modal" id="updateUserModal">
      <div class="modal-content">
        <span class="close" @click="closeUpdateUserModal">&times;</span>
        <h3>Update User</h3>
        <input type="text" v-model="updatedUser.firstname" class="form-control mb-2">
        <input type="text" v-model="updatedUser.lastname" class="form-control mb-2">
        <button @click="updateUser" class="btn btn-primary">Update</button>
      </div>
    </div>
    <div>
      <h2>File Management</h2>
      <input type="file" accept=".csv" @change="handleFileUpload">
      <table class="table mt-5">
        <thead>
          <tr>
            <th>File Name</th>
          </tr>
        </thead>
        <tbody>
              <tr v-for="file in files" :key="file.id">
                <td>{{ file.files_name }}</td>
              </tr> 
        </tbody>

      </table>
      <button @click="sendFile" class="btn btn-primary mt-3">Gönder</button>
    </div>
  </div>
 



</template>

<script>

export default {
  data() {
    return {
      users: [],
      newUser: {
        firstname: '',
        lastname: ''
      },
      updatedUser: {
        id: '',
        firstname: '',
        lastname: ''
      }
    };
  },
  mounted() {
    this.fetchUsers();
  },
  methods: {
    
    fetchUsers() {
      axios.get('/tasks')
        .then(response => {
          this.files = response.data.files;
          this.users = response.data.users;
        })
        .catch(error => {
          console.error('Error fetching users', error);
        });
    },
    deleteUser(userId) {
      axios.delete(`/delete/${userId}`)
        .then(() => {
          // Remove the user from the list
          this.users = this.users.filter(user => user.id !== userId);
          console.log('User deleted successfully');
          toastr.success('User deleted successfully');
        })
        .catch(error => {
          console.error('Error deleting user', error);
          toastr.error('Error deleting user');
        });
    },
    openAddUserModal() {
      document.getElementById('addUserModal').style.display = 'block';
    },
    closeAddUserModal() {
      document.getElementById('addUserModal').style.display = 'none';
    },
    openUpdateUserModal(user) {
      this.updatedUser.id = user.id;
      this.updatedUser.firstname = user.firstname;
      this.updatedUser.lastname = user.lastname;
      document.getElementById('updateUserModal').style.display = 'block';
    },
    closeUpdateUserModal() {
      document.getElementById('updateUserModal').style.display = 'none';
    },
    updateUser() {
      axios.put(`/update/${this.updatedUser.id}`, this.updatedUser)
        .then(() => {
          console.log('User updated successfully');
          toastr.success('User updated successfully');
          this.closeUpdateUserModal();
          this.fetchUsers();
        })
        .catch(error => {
          console.error('Error updating user', error);
          toastr.error('Error updating user');
        });
    },
    addNewUser() {
      axios.post('/add', this.newUser)
        .then(response => {
          console.log('User added successfully');
          toastr.success('User added successfully');
          this.closeAddUserModal();
          this.fetchUsers();
          this.newUser = {
            firstname: '',
            lastname: ''
          };
        })
        .catch(error => {
          console.error('Error adding user', error);
          toastr.error('Error adding user');
        });
    },
handleFileUpload(event) {
    const uploadedFile = event.target.files[0];
    if (!uploadedFile) {
        console.error('Dosya seçilmedi.');
        toastr.error('Lütfen bir dosya seçin.');
        return;
    }
    this.file = uploadedFile;
},



  sendFile() {
    if (!this.file) {
        console.error('Dosya seçilmedi.');
        toastr.error('Lütfen bir dosya seçin.');
        return;
    }

    const formData = new FormData();
    formData.append('file', this.file);

    axios.post('/upload', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
    .then(response => {
        console.log('Dosya başarıyla yüklendi:', response.data);
        toastr.success('Dosya başarıyla yüklendi');
        this.file = null;
    })
    .catch(error => {
        console.error('Dosyayı yüklerken bir hata oluştu:', error);
        toastr.error('Dosyayı yüklerken bir hata oluştu');
    });
}


  }
}
</script>

<style scoped>
/* CSS styles for modal */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
</style>
