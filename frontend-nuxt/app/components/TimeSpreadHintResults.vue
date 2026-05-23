<template>
  <div v-if="hint?.is_query_valid === true" class="order-5">

    <div class="bg-white border border-gray-200 p-3 shadow-md rounded-md text-gray-600 mb-3">
      <b>{{$t('past')}}</b>&nbsp;{{ hint.past_interpretation }}
    </div>

    <div class="bg-white border border-gray-200 p-3 shadow-md rounded-md text-gray-600 mb-3">
      <b>{{$t('present')}}</b>&nbsp;{{ hint.present_interpretation }}
    </div>

    <div class="bg-white border border-gray-200 p-3 shadow-md rounded-md text-gray-600 mb-3">
      <b>{{$t('future')}}</b>&nbsp;{{ hint.future_interpretation }}
    </div>

    <div class="bg-white border border-gray-200 p-3 shadow-md rounded-md text-gray-600 mb-3">
      {{ hint.cross_layer_patterns }}
    </div>

    <div class="bg-white border border-gray-200 p-3 shadow-md rounded-md text-gray-600 mb-3">
      {{ hint.overall_narrative }}
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