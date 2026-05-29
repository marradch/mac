<template>
  <div v-if="hint?.is_query_valid === true" class="order-5">
    <div class="bg-white border border-gray-200 p-3 shadow-md rounded-md text-gray-600 mb-3">
      <b>{{$t('variant')}} 1</b>&nbsp;{{ hint.option1_interpretation }}
    </div>

    <div class="bg-white border border-gray-200 p-3 shadow-md rounded-md text-gray-600 mb-3">
      <b>{{$t('variant')}} 2</b>&nbsp;{{ hint.option2_interpretation }}
    </div>

    <div class="bg-white border border-gray-200 p-3 shadow-md rounded-md text-gray-600 mb-3">
      {{ hint.comparison }}
    </div>

    <div class="bg-white border border-gray-200 p-3 shadow-md rounded-md text-gray-600 mb-3">
      {{ hint.recommendations }}
    </div>

    <AffirmationsFeedback :hint="hint"/>
  </div>

  <div v-else-if="hint?.is_query_valid === false" class="order-5">
    <WrongQuestionFeedback :hint="hint" />
  </div>
</template>

<script setup>
defineProps({
  hint: {
    type: Object,
    required: true
  }
})
</script>