<template>
  <img
    :width="width"
    :style="' border-radius: 100px;  border: 1px solid #dee2e6; padding: 0.15rem;height:'+ height+'px;'"
    :src="image== null || image==''
        ? `${baseURL}/images/avatar.png`
        : `${baseURL}/images/` + image
    "
    alt="image"
  />
</template>

<script>
export default {
  props: {
    image: {
      required: true,
    },
    width:{
        type:Number,
        required:true
    },
    height:{
        type:Number,
        required:true
    }
  },
};
</script>
