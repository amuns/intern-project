<template>
  <!-- <img alt="Vue logo" src="./assets/logo.png" /> -->
  <editor
    api-key="no-api-key"
    :init="{
      height: 500,
      menubar: false,
      plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount',
      ],
      toolbar:
        'undo redo | formatselect | bold italic backcolor | \
            alignleft aligncenter alignright alignjustify | \
            bullist numlist outdent indent | removeformat | help',
    }"
    v-model="getEditorData"
  />

  
</template>

<script setup>
import { ref, computed, onMounted, onUpdated } from "vue";
import Editor from "@tinymce/tinymce-vue";
import { def } from "@vue/shared";

const editorData = ref(null);

const props = defineProps({
  desc: String,
});

// const editorDataEmit = computed(() => editorData.value);
const emit = defineEmits(["editorData"]);

onMounted(() => {
  // editorData.value = props.desc;
});

const getEditorData = computed({
  get() {
    editorData.value = props.desc;
    return editorData;
  },
  set(newValue) {
    editorData.value = newValue;
  },
});
// const getEditorData = ref(props.desc);

onUpdated(() => {
  // emit("editorData", editorData.value);

  // editorData.value = getEditorData.value;
  emit("editorData", getEditorData.value);
});

// const descModel = ref({...DEFAULT_DESC});
</script>
