<template>
  <svg
    xmlns="http://www.w3.org/2000/svg"
    :width="size"
    :height="size"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="2"
    stroke-linecap="round"
    stroke-linejoin="round"
    :class="customClass"
  >
    <path
      v-if="name === 'home'"
      d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"
    ></path>
    <polyline v-if="name === 'home'" points="9 22 9 12 15 12 15 22"></polyline>

    <path
      v-if="name === 'file-text'"
      d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
    ></path>
    <polyline v-if="name === 'file-text'" points="14 2 14 8 20 8"></polyline>
    <line v-if="name === 'file-text'" x1="16" y1="13" x2="8" y2="13"></line>
    <line v-if="name === 'file-text'" x1="16" y1="17" x2="8" y2="17"></line>
    <polyline v-if="name === 'file-text'" points="10 9 9 9 8 9"></polyline>

    <path
      v-if="name === 'message-square'"
      d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"
    ></path>

    <path
      v-if="name === 'tag'"
      d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"
    ></path>
    <line v-if="name === 'tag'" x1="7" y1="7" x2="7.01" y2="7"></line>

    <rect
      v-if="name === 'credit-card'"
      x="1"
      y="4"
      width="22"
      height="16"
      rx="2"
      ry="2"
    ></rect>
    <line v-if="name === 'credit-card'" x1="1" y1="10" x2="23" y2="10"></line>

    <circle v-if="name === 'settings'" cx="12" cy="12" r="3"></circle>
    <path
      v-if="name === 'settings'"
      d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"
    ></path>

    <path
      v-if="name === 'log-out'"
      d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"
    ></path>
    <polyline v-if="name === 'log-out'" points="16 17 21 12 16 7"></polyline>
    <line v-if="name === 'log-out'" x1="21" y1="12" x2="9" y2="12"></line>

    <polyline v-if="name === 'chevron-down'" points="6 9 12 15 18 9"></polyline>
    <polyline
      v-if="name === 'chevron-right'"
      points="9 18 15 12 9 6"
    ></polyline>
    <polyline
      v-if="name === 'chevron-left'"
      points="15 18 9 12 15 6"
    ></polyline>

    <line v-if="name === 'menu'" x1="3" y1="12" x2="21" y2="12"></line>
    <line v-if="name === 'menu'" x1="3" y1="6" x2="21" y2="6"></line>
    <line v-if="name === 'menu'" x1="3" y1="18" x2="21" y2="18"></line>

    <path
      v-if="name === 'download'"
      d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"
    ></path>
    <polyline v-if="name === 'download'" points="7 10 12 15 17 10"></polyline>
    <line v-if="name === 'download'" x1="12" y1="15" x2="12" y2="3"></line>

    <path
      v-if="name === 'upload'"
      d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"
    ></path>
    <polyline v-if="name === 'upload'" points="17 8 12 3 7 8"></polyline>
    <line v-if="name === 'upload'" x1="12" y1="3" x2="12" y2="21"></line>

    <path v-if="name === 'wifi'" d="M5 12.55a11 11 0 0 1 14.08 0"></path>
    <path v-if="name === 'wifi'" d="M1.42 9a16 16 0 0 1 21.16 0"></path>
    <path v-if="name === 'wifi'" d="M8.53 16.11a6 6 0 0 1 6.95 0"></path>
    <line v-if="name === 'wifi'" x1="12" y1="20" x2="12.01" y2="20"></line>

    <line v-if="name === 'wifi-off'" x1="1" y1="1" x2="23" y2="23"></line>
    <path
      v-if="name === 'wifi-off'"
      d="M16.72 11.06A10.94 10.94 0 0 1 19 12.55"
    ></path>
    <path
      v-if="name === 'wifi-off'"
      d="M5 12.55a10.94 10.94 0 0 1 5.17-2.39"
    ></path>
    <path v-if="name === 'wifi-off'" d="M10.71 5.05A16 16 0 0 1 22.58 9"></path>
    <path
      v-if="name === 'wifi-off'"
      d="M1.42 9a15.91 15.91 0 0 1 4.7-2.88"
    ></path>
    <path v-if="name === 'wifi-off'" d="M8.53 16.11a6 6 0 0 1 6.95 0"></path>
    <line v-if="name === 'wifi-off'" x1="12" y1="20" x2="12.01" y2="20"></line>

    <line v-if="name === 'dollar-sign'" x1="12" y1="1" x2="12" y2="23"></line>
    <path
      v-if="name === 'dollar-sign'"
      d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"
    ></path>

    <polyline
      v-if="name === 'activity'"
      points="22 12 18 12 15 21 9 3 6 12 2 12"
    ></polyline>

    <circle v-if="name === 'clock'" cx="12" cy="12" r="10"></circle>
    <polyline v-if="name === 'clock'" points="12 6 12 12 16 14"></polyline>

    <path
      v-if="name === 'gauge'"
      d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
    ></path>
    <path v-if="name === 'gauge'" d="M13.4 10.6 19 5"></path>
    <path v-if="name === 'gauge'" d="M12 20a9 9 0 1 1 9-9"></path>

    <rect
      v-if="name === 'sidebar'"
      x="3"
      y="3"
      width="18"
      height="18"
      rx="2"
      ry="2"
    ></rect>
    <line v-if="name === 'sidebar'" x1="9" y1="3" x2="9" y2="21"></line>

    <path
      v-if="name === 'eye'"
      d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12Z"
    ></path>
    <circle v-if="name === 'eye'" cx="12" cy="12" r="3"></circle>

    <circle v-if="name === 'search'" cx="11" cy="11" r="8"></circle>
    <line v-if="name === 'search'" x1="21" y1="21" x2="16.65" y2="16.65"></line>

    <path v-if="name === 'filter'" d="M4 4h16l-6 8v5l-4 2v-7Z"></path>

    <polyline v-if="name === 'check'" points="20 6 9 17 4 12"></polyline>

    <line v-if="name === 'plus'" x1="12" y1="5" x2="12" y2="19"></line>
    <line v-if="name === 'plus'" x1="5" y1="12" x2="19" y2="12"></line>

    <path
      v-if="name === 'chat-bubble'"
      d="M4 5h16v11H8l-4 4V5Z"
    ></path>

    <circle v-if="name === 'clock-round'" cx="12" cy="12" r="9"></circle>
    <polyline v-if="name === 'clock-round'" points="12 7 12 12 15 14"></polyline>

    <path
      v-if="name === 'check-round'"
      d="M21 11a9 9 0 1 1-4.22-7.53"
    ></path>
    <polyline v-if="name === 'check-round'" points="6 12 11 17 20 5"></polyline>

    <circle v-if="name === 'alert-circle'" cx="12" cy="12" r="9"></circle>
    <line v-if="name === 'alert-circle'" x1="12" y1="8" x2="12" y2="13"></line>
    <line v-if="name === 'alert-circle'" x1="12" y1="17" x2="12.01" y2="17"></line>
  </svg>
</template>

<script setup>
defineProps({
  name: {
    type: String,
    required: true,
  },
  size: {
    type: [Number, String],
    default: 24,
  },
  customClass: {
    type: String,
    default: "",
  },
});
</script>
