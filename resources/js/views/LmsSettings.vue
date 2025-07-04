<template>
  <div class="settings-dashboard" :class="isDark ? 'dark' : ''">
    <div class="settings-header flex items-center gap-4 mb-8">
      <img :src="avatarPreview || userAvatar" class="settings-avatar cursor-pointer" @click="openAvatarModal" />
      <div>
        <h2 class="text-2xl font-bold mb-1">Account Settings</h2>
        <p class="text-gray-500 dark:text-gray-300">Manage your personal information, password, and preferences</p>
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- Profile Info Card -->
      <div class="settings-card">
        <h3 class="settings-card-title">Profile Information</h3>
        <form @submit.prevent="updateName" class="settings-form">
          <label>Name</label>
          <input v-model="name" type="text" required />
          <button type="submit">Update Name</button>
          <span v-if="nameSuccess" class="success">Name updated!</span>
          <span v-if="nameError" class="error">{{ nameError }}</span>
        </form>
        <form @submit.prevent="updateAvatar" enctype="multipart/form-data" class="settings-form mt-4">
          <label>Profile Photo</label>
          <input type="file" @change="onAvatarChange" accept="image/*" />
          <button type="submit">Update Photo</button>
          <span v-if="avatarSuccess" class="success">Photo updated!</span>
          <span v-if="avatarError" class="error">{{ avatarError }}</span>
        </form>
      </div>
      <!-- Password Card -->
      <div class="settings-card">
        <h3 class="settings-card-title">Change Password</h3>
        <form @submit.prevent="updatePassword" class="settings-form">
          <label>Current Password</label>
          <input v-model="currentPassword" type="password" required />
          <label>New Password</label>
          <input v-model="newPassword" type="password" required />
          <label>Confirm New Password</label>
          <input v-model="confirmPassword" type="password" required />
          <button type="submit">Update Password</button>
          <span v-if="passwordSuccess" class="success">Password updated!</span>
          <span v-if="passwordError" class="error">{{ passwordError }}</span>
        </form>
      </div>
    </div>
    <div class="settings-card mt-8 max-w-md mx-auto">
      <h3 class="settings-card-title">Theme</h3>
      <div class="flex items-center gap-4 mt-2">
        <span>Appearance:</span>
        <button @click="toggleTheme" class="theme-toggle-btn">
          <span v-if="isDark">🌙 Dark Mode</span>
          <span v-else>☀️ Light Mode</span>
        </button>
      </div>
    </div>

    <!-- Avatar Modal -->
    <transition name="fade">
      <div v-if="showAvatarModal" class="modal-overlay" @click.self="closeAvatarModal">
        <div class="modal-content">
          <button class="modal-close" @click="closeAvatarModal">&times;</button>
          <img :src="avatarPreview || userAvatar" class="modal-avatar" />
          <form @submit.prevent="updateAvatar" enctype="multipart/form-data" class="modal-form">
            <input type="file" @change="onAvatarChange" accept="image/*" />
            <button type="submit" :disabled="!avatarFile.value">Change Photo</button>
            <span v-if="avatarSuccess" class="success">Photo updated!</span>
            <span v-if="avatarError" class="error">{{ avatarError }}</span>
          </form>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useTheme } from '../composables/useTheme';

const name = ref('');
const userAvatar = ref('');
const nameSuccess = ref(false);
const nameError = ref('');

const currentPassword = ref('');
const newPassword = ref('');
const confirmPassword = ref('');
const passwordSuccess = ref(false);
const passwordError = ref('');

const avatarFile = ref(null);
const avatarPreview = ref('');
const avatarSuccess = ref(false);
const avatarError = ref('');

const showAvatarModal = ref(false);

const { isDark, toggleTheme } = useTheme();

onMounted(async () => {
  // Fetch user info for avatar and name
  try {
    const res = await axios.get('/api/auth/user');
    name.value = res.data.user.name;
    userAvatar.value = res.data.user.avatar_url || res.data.user.avatar || '/assets/image/default-avatar.png';
  } catch {
    userAvatar.value = '/assets/image/default-avatar.png';
  }
});

const openAvatarModal = () => {
  showAvatarModal.value = true;
};
const closeAvatarModal = () => {
  showAvatarModal.value = false;
  avatarError.value = '';
  avatarSuccess.value = false;
};

const updateName = async () => {
  nameSuccess.value = false;
  nameError.value = '';
  try {
    await axios.patch('/api/user/settings?type=name', { name: name.value });
    nameSuccess.value = true;
  } catch (e) {
    nameError.value = e.response?.data?.message || 'Failed to update name.';
  }
};

const updatePassword = async () => {
  passwordSuccess.value = false;
  passwordError.value = '';
  if (newPassword.value !== confirmPassword.value) {
    passwordError.value = 'Passwords do not match.';
    return;
  }
  try {
    await axios.patch('/api/user/settings?type=password', {
      current_password: currentPassword.value,
      password: newPassword.value,
      password_confirmation: confirmPassword.value,
    });
    passwordSuccess.value = true;
    currentPassword.value = '';
    newPassword.value = '';
    confirmPassword.value = '';
  } catch (e) {
    passwordError.value = e.response?.data?.message || 'Failed to update password.';
  }
};

const onAvatarChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    avatarFile.value = file;
    avatarPreview.value = URL.createObjectURL(file);
  }
};

const updateAvatar = async () => {
  avatarSuccess.value = false;
  avatarError.value = '';
  if (!avatarFile.value) {
    avatarError.value = 'Please select a photo before submitting.';
    return;
  }
  const formData = new FormData();
  formData.append('avatar', avatarFile.value);
  try {
    const res = await axios.post('/api/user/settings?type=avatar', formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
    });
    avatarSuccess.value = true;
    avatarFile.value = null;
    avatarPreview.value = res.data.avatar_url;
    userAvatar.value = res.data.avatar_url;
  } catch (e) {
    avatarError.value = e.response?.data?.message || 'Failed to update photo.';
  }
};
</script>

<style scoped>
.settings-dashboard {
  padding: 2rem 1rem 4rem 1rem;
}
.settings-header {
  margin-bottom: 2rem;
}
.settings-avatar {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #1976d2;
  background: #fff;
  box-shadow: 0 2px 8px rgba(25, 118, 210, 0.08);
  transition: box-shadow 0.2s, border 0.2s;
}
.settings-avatar:hover {
  box-shadow: 0 4px 24px rgba(25, 118, 210, 0.18);
  border-color: #1565c0;
  cursor: pointer;
}
.settings-card {
  background: #fff;
  border-radius: 1rem;
  box-shadow: 0 2px 16px rgba(0,0,0,0.08);
  padding: 2rem 1.5rem;
  margin-bottom: 1.5rem;
  transition: background 0.3s;
}
.dark .settings-card {
  background: #1e293b;
  color: #fff;
}
.settings-card-title {
  font-size: 1.2rem;
  font-weight: 600;
  margin-bottom: 1.2rem;
}
.settings-form {
  display: flex;
  flex-direction: column;
  gap: 0.7rem;
}
.settings-form input[type="text"],
.settings-form input[type="password"] {
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 0.5rem;
  background: #f8fafc;
  transition: border 0.2s;
}
.dark .settings-form input[type="text"],
.dark .settings-form input[type="password"] {
  background: #334155;
  color: #fff;
  border: 1px solid #475569;
}
.settings-form button {
  margin-top: 0.5rem;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 0.5rem;
  background: #1976d2;
  color: #fff;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s;
}
.settings-form button:hover {
  background: #1565c0;
}
.success {
  color: #388e3c;
  font-size: 0.95rem;
}
.error {
  color: #d32f2f;
  font-size: 0.95rem;
}
.theme-toggle-btn {
  background: #1976d2;
  color: #fff;
  border: none;
  border-radius: 0.5rem;
  padding: 0.5rem 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s;
}
.theme-toggle-btn:hover {
  background: #1565c0;
}
/* Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(30, 41, 59, 0.7);
  z-index: 50;
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal-content {
  background: #fff;
  border-radius: 1rem;
  padding: 2rem 2.5rem 1.5rem 2.5rem;
  box-shadow: 0 8px 32px rgba(25, 118, 210, 0.18);
  position: relative;
  min-width: 320px;
  max-width: 90vw;
  text-align: center;
}
.dark .modal-content {
  background: #1e293b;
  color: #fff;
}
.modal-close {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: none;
  border: none;
  font-size: 2rem;
  color: #888;
  cursor: pointer;
  transition: color 0.2s;
}
.modal-close:hover {
  color: #d32f2f;
}
.modal-avatar {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #1976d2;
  margin-bottom: 1.5rem;
  background: #fff;
  box-shadow: 0 2px 8px rgba(25, 118, 210, 0.08);
}
.modal-form {
  display: flex;
  flex-direction: column;
  gap: 0.7rem;
  align-items: center;
}
.modal-form button[disabled] {
  background: #b0b8c1;
  cursor: not-allowed;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.2s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
