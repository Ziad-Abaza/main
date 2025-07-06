<template>
  <div v-if="assignment" class="text-white">
    <div class="flex flex-wrap -mx-4">
      <!-- Main Content Column -->
      <div class="w-full lg:w-8/12 px-4">
        <!-- Header -->
        <div class="bg-gray-800 shadow-lg rounded-lg p-6 mb-6">
          <h1 class="text-3xl font-bold mb-1">{{ assignment.title }}</h1>
          <router-link
            v-if="assignment.course"
            :to="{ name: 'courses-detail', params: { id: assignment.course.course_id } }"
            class="text-blue-400 hover:underline"
          >
            <font-awesome-icon :icon="['fas', 'book']" class="mr-2" />
            {{ assignment.course.title }}
          </router-link>
          <span v-else class="text-gray-400">No course info</span>
        </div>

        <!-- Description -->
        <div class="bg-gray-800 shadow-lg rounded-lg p-6 mb-6">
          <h2 class="text-2xl font-semibold mb-3">Description</h2>
          <p class="text-gray-300 whitespace-pre-wrap">{{ assignment.description }}</p>
        </div>

        <!-- Attachment -->
        <div
          v-if="assignment.has_attachment"
          class="bg-gray-800 shadow-lg rounded-lg p-6 mb-6"
        >
          <h2 class="text-2xl font-semibold mb-4">Attachment</h2>
          <div class="flex items-center bg-gray-900 p-4 rounded-md">
            <font-awesome-icon
              :icon="['fas', 'file-alt']"
              class="text-3xl text-gray-400 mr-4"
            />
            <div class="flex-grow">
              <span class="font-bold">Assignment File</span>
              <span class="block text-sm text-gray-400">{{
                fileExtension.toUpperCase()
              }}</span>
            </div>
            <button
              @click="showPreviewModal = true"
              v-if="canPreview"
              class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-md mr-2"
            >
              <font-awesome-icon :icon="['fas', 'eye']" class="mr-2" />Preview
            </button>
            <button
              @click="downloadFile"
              class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md"
            >
              <font-awesome-icon :icon="['fas', 'download']" class="mr-2" />Download
            </button>
          </div>
        </div>

        <!-- Submission Section -->
        <div class="bg-gray-800 shadow-lg rounded-lg">
          <div class="p-6 border-b border-gray-700">
            <h2 class="text-2xl font-semibold">Your Submission</h2>
          </div>
          <div class="p-6">
            <!-- Already Submitted View -->
            <div v-if="isSubmitted">
              <p class="text-gray-300 mb-4">
                Submitted on:
                <span class="font-semibold text-white">{{
                  formatDate(assignment.submission.created_at)
                }}</span>
              </p>
              <div v-if="assignment.submission.comment" class="mb-4">
                <h3 class="font-semibold mb-2">Your Comment:</h3>
                <p class="text-gray-300 bg-gray-900 p-3 rounded-md italic">
                  "{{ assignment.submission.comment }}"
                </p>
              </div>
              <div v-if="assignment.submission.feedback" class="mb-4">
                <h3 class="font-semibold mb-2">Instructor Feedback:</h3>
                <p class="text-green-300 bg-gray-900 p-3 rounded-md italic">
                  "{{ assignment.submission.feedback }}"
                </p>
              </div>
              <div v-if="assignment.submission.grade !== null" class="mb-4">
                <h3 class="font-semibold mb-2">Grade:</h3>
                <p class="text-white text-xl font-bold">
                  {{ assignment.submission.grade }}
                </p>
              </div>
              <a
                v-if="assignment.submission.has_feedback_file"
                :href="assignment.submission.feedback_file_url"
                download
                class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md mb-4"
              >
                <font-awesome-icon :icon="['fas', 'download']" class="mr-2" />Download
                Feedback File
              </a>
              <div
                v-if="
                  assignment.submission.answers &&
                  assignment.submission.answers.length > 0
                "
                class="mb-4"
              >
                <h3 class="font-semibold mb-2">Your Answers:</h3>
                <ul class="space-y-2">
                  <li
                    v-for="(answer, index) in assignment.submission.answers"
                    :key="index"
                    class="bg-gray-900 p-3 rounded-md text-gray-300"
                  >
                    {{ answer }}
                  </li>
                </ul>
              </div>
              <button
                v-if="assignment.submission.has_file"
                @click="downloadSubmission"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md"
              >
                <font-awesome-icon :icon="['fas', 'download']" class="mr-2" />Download
                Submitted File
              </button>

              <!-- Modify / Delete Buttons -->
              <div v-if="canModify" class="mt-4 flex space-x-3">
                <button
                  @click="showEditForm = !showEditForm"
                  class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-md"
                >
                  <font-awesome-icon :icon="['fas', 'pen']" class="mr-2" />Replace
                  Submission
                </button>
                <button
                  @click="deleteSubmission"
                  class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md"
                >
                  <font-awesome-icon :icon="['fas', 'trash']" class="mr-2" />Delete
                  Submission
                </button>
              </div>

              <!-- Replace Form -->
              <form
                v-if="showEditForm"
                @submit.prevent="updateSubmission"
                class="space-y-6 mt-6 bg-gray-900 p-6 rounded-lg"
              >
                <div>
                  <label
                    for="edit-file"
                    class="block text-sm font-medium text-gray-300 mb-1"
                    >New File (Required)</label
                  >
                  <input
                    id="edit-file"
                    type="file"
                    ref="editFileInput"
                    class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-700 file:text-gray-300 hover:file:bg-gray-600"
                  />
                </div>
                <div>
                  <label
                    for="edit-comment"
                    class="block text-sm font-medium text-gray-300 mb-1"
                    >Comment (Optional)</label
                  >
                  <textarea
                    id="edit-comment"
                    v-model="editComment"
                    rows="3"
                    class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Update your comment (optional)"
                  ></textarea>
                </div>
                <button
                  type="submit"
                  :disabled="updating"
                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 disabled:opacity-50"
                >
                  <span
                    v-if="updating"
                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                  ></span>
                  Save Changes
                </button>
              </form>
            </div>

            <!-- Submission Form -->
            <form @submit.prevent="submitAssignment" v-else class="space-y-6">
              <div>
                <label for="file" class="block text-sm font-medium text-gray-300 mb-1"
                  >Attach File (Required)</label
                >
                <input
                  id="file"
                  type="file"
                  ref="fileInput"
                  class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-700 file:text-gray-300 hover:file:bg-gray-600"
                />
              </div>
              <div>
                <label for="comment" class="block text-sm font-medium text-gray-300 mb-1"
                  >Comment (Optional)</label
                >
                <textarea
                  id="comment"
                  v-model="comment"
                  rows="3"
                  class="w-full bg-gray-700 border border-gray-600 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="Add a comment for your instructor."
                ></textarea>
              </div>
              <button
                type="submit"
                :disabled="submitting"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
              >
                <span
                  v-if="submitting"
                  class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                ></span>
                Submit Assignment
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Side Column -->
      <div class="w-full lg:w-4/12 px-4 mt-6 lg:mt-0">
        <div class="bg-gray-800 shadow-lg rounded-lg sticky top-6">
          <div class="p-6 border-b border-gray-700">
            <h2 class="text-2xl font-semibold">Status</h2>
          </div>
          <div class="p-6 space-y-4">
            <div class="flex justify-between items-center">
              <span class="font-semibold">Status</span>
              <span
                class="px-3 py-1 text-sm font-bold rounded-full"
                :class="statusBadgeClass"
                >{{ statusText }}</span
              >
            </div>
            <div class="flex justify-between items-center">
              <span class="font-semibold">Due Date</span>
              <span class="text-gray-300">{{
                formatDate(assignment.due_date, "PPpp")
              }}</span>
            </div>
            <hr class="border-gray-700" />
            <div class="text-center text-gray-300">
              <p class="text-lg">{{ timeDifferenceText }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Preview Modal -->
    <div
      v-if="showPreviewModal"
      class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4"
    >
      <div
        class="bg-gray-800 rounded-lg shadow-xl w-full max-w-4xl max-h-full overflow-auto"
      >
        <div class="p-4 flex justify-between items-center border-b border-gray-700">
          <h3 class="text-xl font-semibold">Attachment Preview</h3>
          <button
            @click="showPreviewModal = false"
            class="text-gray-400 hover:text-white"
          >
            <font-awesome-icon :icon="['fas', 'xmark']" class="h-6 w-6" />
          </button>
        </div>
        <div class="p-4">
          <img
            v-if="isImage"
            :src="previewUrl"
            class="max-w-full max-h-[80vh] mx-auto rounded"
            alt="Preview"
          />
          <iframe
            v-else-if="isPdf"
            :src="previewUrl"
            class="w-full h-[80vh]"
            frameborder="0"
          ></iframe>
          <p v-else class="text-center py-10">
            Preview not available for this file type.
          </p>
        </div>
      </div>
    </div>

    <Toast ref="toastRef" />
  </div>
  <div v-else class="text-center text-gray-400 p-10">
    <div
      class="animate-spin rounded-full h-12 w-12 border-b-2 border-white mx-auto"
    ></div>
    <p class="mt-4">Loading Assignment...</p>
  </div>
</template>

<script setup>
// Imports
import { ref, computed, getCurrentInstance } from "vue";
import axios from "axios";
import { format, formatDistanceToNow, isPast } from "date-fns";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
  faBook,
  faFileAlt,
  faEye,
  faDownload,
  faXmark,
  faPen,
  faTrash,
} from "@fortawesome/free-solid-svg-icons";
import { library } from "@fortawesome/fontawesome-svg-core";
import Toast from "@/components/ui/Toast.vue";

// Add icons to the library
library.add(faBook, faFileAlt, faEye, faDownload, faXmark, faPen, faTrash);

const props = defineProps({
  assignment: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(["submission-success"]);

// State
const fileInput = ref(null);
const submitting = ref(false);
const showPreviewModal = ref(false);
const comment = ref("");
const editComment = ref("");
const showEditForm = ref(false);
const { proxy } = getCurrentInstance();
const toastRef = ref(null);

// Computed properties for UI logic
const isSubmitted = computed(() => !!props.assignment.submission);
const dueDate = computed(() => new Date(props.assignment.due_date));

const statusText = computed(() => {
  if (isSubmitted.value) return "Submitted";
  if (isPast(dueDate.value)) return "Overdue";
  return "Pending";
});

const statusBadgeClass = computed(() => {
  if (isSubmitted.value) return "bg-green-600 text-white";
  if (isPast(dueDate.value)) return "bg-red-600 text-white";
  return "bg-yellow-500 text-gray-900";
});

const timeDifferenceText = computed(() => {
  if (isSubmitted.value)
    return `Submitted on ${format(
      new Date(props.assignment.submission.created_at),
      "PP"
    )}`;
  return formatDistanceToNow(dueDate.value, { addSuffix: true });
});

const previewUrl = computed(() => {
  if (!props.assignment.has_attachment) return null;
  return `/api/assignments/${props.assignment.id}/view`;
});

const fileExtension = computed(() => {
  if (!props.assignment.attachment_url) return "";
  return props.assignment.attachment_url.split(".").pop().toLowerCase();
});

const isImage = computed(() =>
  ["jpg", "jpeg", "png", "gif"].includes(fileExtension.value)
);
const isPdf = computed(() => fileExtension.value === "pdf");
const canPreview = computed(() => isImage.value || isPdf.value);

const canModify = computed(() => {
  if (!props.assignment.submission) return false;
  const graded =
    props.assignment.submission.grade !== null ||
    props.assignment.submission.feedback !== null;
  // allow modify if before deadline and not graded
  return !isPast(dueDate.value) && !graded;
});

// Helper to extract filename from content-disposition header
const getFileNameFromHeader = (header) => {
  if (!header) return null;
  const matches = header.match(/filename="([^"]+)"/);
  return matches ? matches[1] : null;
};

// Reusable download logic
const performDownload = async (url, defaultFileName) => {
  try {
    const response = await axios.get(url, { responseType: "blob" });
    const blobUrl = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement("a");
    const fileName =
      getFileNameFromHeader(response.headers["content-disposition"]) || defaultFileName;

    link.href = blobUrl;
    link.setAttribute("download", fileName);
    document.body.appendChild(link);
    link.click();
    link.remove();
    window.URL.revokeObjectURL(blobUrl);
  } catch (error) {
    console.error("Error downloading file:", error);
    toastRef.value?.show("Failed to download file.", "danger");
  }
};

const downloadFile = () => {
  performDownload(
    `/api/assignments/${props.assignment.id}/download`,
    `assignment-${props.assignment.id}.${fileExtension.value}`
  );
};

const downloadSubmission = () => {
  if (!props.assignment.submission?.has_file) return;
  const subExt = props.assignment.submission.file_url.split(".").pop();
  performDownload(
    `/api/assignments/${props.assignment.id}/submissions/${props.assignment.submission.id}/download`,
    `submission-${props.assignment.submission.id}.${subExt}`
  );
};

const submitAssignment = async () => {
  submitting.value = true;
  try {
    const formData = new FormData();
    if (comment.value.trim()) {
      formData.append("comment", comment.value);
    }
    if (fileInput.value?.files[0]) {
      formData.append("file", fileInput.value.files[0]);
    }

    if (!formData.has("file")) {
      toastRef.value?.show("Please attach a file to submit.", "danger");
      submitting.value = false;
      return;
    }

    const response = await axios.post(
      `/api/assignments/${props.assignment.id}/submit`,
      formData,
      {
        headers: { "Content-Type": "multipart/form-data" },
      }
    );

    toastRef.value?.show("Assignment submitted successfully!", "success");
    emit("submission-success", response.data.data);
  } catch (error) {
    toastRef.value?.show("Failed to submit assignment.", "danger");
  } finally {
    submitting.value = false;
  }
};

const deleteSubmission = async () => {
  if (!props.assignment.submission?.has_file) return;
  try {
    await axios.delete(`/api/assignments/${props.assignment.id}/submit`);
    // fetch fresh assignment without submission
    const res = await axios.get(`/api/assignments/${props.assignment.id}`);
    toastRef.value?.show("Submission deleted", "success");
    emit("submission-success", res.data.data);
  } catch (e) {
    toastRef.value?.show("Delete failed", "danger");
  }
};

const updating = ref(false);
const editFileInput = ref(null);

const updateSubmission = async () => {
  updating.value = true;
  try {
    const formData = new FormData();
    if (editComment.value.trim()) {
      formData.append("comment", editComment.value);
    }
    if (editFileInput.value?.files[0]) {
      formData.append("file", editFileInput.value.files[0]);
    }

    if (!formData.has("file")) {
      toastRef.value?.show("Please attach a file to update.", "danger");
      updating.value = false;
      return;
    }

    const response = await axios.patch(
      `/api/assignments/${props.assignment.id}/submit`,
      formData,
      {
        headers: { "Content-Type": "multipart/form-data" },
      }
    );

    toastRef.value?.show("Submission updated successfully!", "success");
    emit("submission-success", response.data.data);
  } catch (error) {
    toastRef.value?.show("Failed to update submission.", "danger");
  } finally {
    updating.value = false;
    showEditForm.value = false;
  }
};

const formatDate = (dateString, formatStr = "PP") => {
  if (!dateString) return "";
  return format(new Date(dateString), formatStr);
};
</script>

<style scoped>
/* A simple spinner for the submit button */
.animate-spin {
  animation: spin 1s linear infinite;
}
@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>
