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
      v-if="name === 'edit'"
      d="M12 20h9"
    ></path>
    <path
      v-if="name === 'edit'"
      d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"
    ></path>

    <path
      v-if="name === 'trash'"
      d="M3 6h18"
    ></path>
    <path
      v-if="name === 'trash'"
      d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
    ></path>
    <path
      v-if="name === 'trash'"
      d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"
    ></path>

    <circle v-if="name === 'slash-circle'" cx="12" cy="12" r="9"></circle>
    <line
      v-if="name === 'slash-circle'"
      x1="8"
      y1="16"
      x2="16"
      y2="8"
    ></line>

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

    <polyline
      v-if="name === 'trend-up'"
      points="23 6 14 15 9 10 1 18"
    ></polyline>
    <polyline v-if="name === 'trend-up'" points="17 6 23 6 23 12"></polyline>

    <circle v-if="name === 'clock'" cx="12" cy="12" r="10"></circle>
    <polyline v-if="name === 'clock'" points="12 6 12 12 16 14"></polyline>

    <rect
      v-if="name === 'calendar'"
      x="3"
      y="4"
      width="18"
      height="18"
      rx="2"
      ry="2"
    ></rect>
    <line v-if="name === 'calendar'" x1="16" y1="2" x2="16" y2="6"></line>
    <line v-if="name === 'calendar'" x1="8" y1="2" x2="8" y2="6"></line>
    <line v-if="name === 'calendar'" x1="3" y1="10" x2="21" y2="10"></line>

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

    <line v-if="name === 'pause'" x1="9" y1="5" x2="9" y2="19"></line>
    <line v-if="name === 'pause'" x1="15" y1="5" x2="15" y2="19"></line>

    <line v-if="name === 'x'" x1="18" y1="6" x2="6" y2="18"></line>
    <line v-if="name === 'x'" x1="6" y1="6" x2="18" y2="18"></line>

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

    <path
      v-if="name === 'shield-check'"
      d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"
    ></path>
    <polyline
      v-if="name === 'shield-check'"
      points="9.5 12.5 12 15 15 10"
    ></polyline>

    <rect
      v-if="name === 'monitor'"
      x="2"
      y="3"
      width="20"
      height="14"
      rx="2"
      ry="2"
    ></rect>
    <line v-if="name === 'monitor'" x1="8" y1="21" x2="16" y2="21"></line>
    <line v-if="name === 'monitor'" x1="12" y1="17" x2="12" y2="21"></line>

    <rect
      v-if="name === 'smartphone'"
      x="5"
      y="2"
      width="14"
      height="20"
      rx="2"
      ry="2"
    ></rect>
    <line v-if="name === 'smartphone'" x1="12" y1="18" x2="12.01" y2="18"></line>

    <rect v-if="name === 'mail'" x="2" y="4" width="20" height="16" rx="2" ry="2"></rect>
    <polyline v-if="name === 'mail'" points="22,6 12,13 2,6"></polyline>

    <path
      v-if="name === 'user'"
      d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"
    ></path>
    <circle v-if="name === 'user'" cx="12" cy="7" r="4"></circle>

    <circle v-if="name === 'life-buoy'" cx="12" cy="12" r="10"></circle>
    <circle v-if="name === 'life-buoy'" cx="12" cy="12" r="4"></circle>
    <line v-if="name === 'life-buoy'" x1="4.93" y1="4.93" x2="9.17" y2="9.17"></line>
    <line v-if="name === 'life-buoy'" x1="14.83" y1="14.83" x2="19.07" y2="19.07"></line>
    <line v-if="name === 'life-buoy'" x1="14.83" y1="9.17" x2="19.07" y2="4.93"></line>
    <line v-if="name === 'life-buoy'" x1="9.17" y1="14.83" x2="4.93" y2="19.07"></line>

    <rect
      v-if="name === 'lock'"
      x="3"
      y="11"
      width="18"
      height="11"
      rx="2"
      ry="2"
    ></rect>
    <path v-if="name === 'lock'" d="M7 11V7a5 5 0 0 1 10 0v4"></path>

    <path
      v-if="name === 'bell'"
      d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"
    ></path>
    <path v-if="name === 'bell'" d="M13.73 21a2 2 0 0 1-3.46 0"></path>

    <rect
      v-if="name === 'gift'"
      x="2"
      y="7"
      width="20"
      height="5"
      rx="1"
    ></rect>
    <polyline
      v-if="name === 'gift'"
      points="20 12 20 22 4 22 4 12"
    ></polyline>
    <line v-if="name === 'gift'" x1="12" y1="7" x2="12" y2="22"></line>
    <path
      v-if="name === 'gift'"
      d="M12 7a3 3 0 1 0-3-3c0 1.66 1.34 3 3 3"
    ></path>
    <path
      v-if="name === 'gift'"
      d="M12 7a3 3 0 1 1 3-3c0 1.66-1.34 3-3 3"
    ></path>

    <circle v-if="name === 'info'" cx="12" cy="12" r="10"></circle>
    <line v-if="name === 'info'" x1="12" y1="16" x2="12" y2="12"></line>
    <line v-if="name === 'info'" x1="12" y1="8" x2="12.01" y2="8"></line>

    <line v-if="name === 'percent'" x1="19" y1="5" x2="5" y2="19"></line>
    <circle v-if="name === 'percent'" cx="6.5" cy="6.5" r="2.5"></circle>
    <circle v-if="name === 'percent'" cx="17.5" cy="17.5" r="2.5"></circle>

    <polygon
      v-if="name === 'zap'"
      points="13 2 3 14 12 14 11 22 21 10 12 10"
    ></polygon>

    <rect
      v-if="name === 'tv'"
      x="2"
      y="7"
      width="20"
      height="15"
      rx="2"
      ry="2"
    ></rect>
    <polyline v-if="name === 'tv'" points="17 2 12 7 7 2"></polyline>

    <path
      v-if="name === 'headphones'"
      d="M3 18v-6a9 9 0 0 1 18 0v6"
    ></path>
    <path
      v-if="name === 'headphones'"
      d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"
    ></path>
    <path
      v-if="name === 'headphones'"
      d="M3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3"
    ></path>

    <path
      v-if="name === 'shield'"
      d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"
    ></path>

    <path
      v-if="name === 'users'"
      d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"
    ></path>
    <circle v-if="name === 'users'" cx="9" cy="7" r="4"></circle>
    <path
      v-if="name === 'users'"
      d="M23 21v-2a4 4 0 0 0-3-3.87"
    ></path>
    <path
      v-if="name === 'users'"
      d="M16 3.13a4 4 0 0 1 0 7.75"
    ></path>

    <path
      v-if="name === 'phone-call'"
      d="M15.05 5A5 5 0 0 1 19 8.95"
    ></path>
    <path
      v-if="name === 'phone-call'"
      d="M15.05 1A9 9 0 0 1 23 8.94"
    ></path>
    <path
      v-if="name === 'phone-call'"
      d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7 2 2 0 0 1 1.72 2.03z"
    ></path>

    <path
      v-if="name === 'user-check'"
      d="M20 21v-2a4 4 0 0 0-3-3.87"
    ></path>
    <path
      v-if="name === 'user-check'"
      d="M4 21v-2a4 4 0 0 1 4-4h4"
    ></path>
    <circle v-if="name === 'user-check'" cx="12" cy="7" r="4"></circle>
    <polyline v-if="name === 'user-check'" points="16 11 18 13 22 9"></polyline>

    <polygon
      v-if="name === 'layers'"
      points="12 2 2 7 12 12 22 7 12 2"
    ></polygon>
    <polyline v-if="name === 'layers'" points="2 12 12 17 22 12"></polyline>
    <polyline v-if="name === 'layers'" points="2 17 12 22 22 17"></polyline>
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
