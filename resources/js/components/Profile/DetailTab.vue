<template>
  <v-table density="compact">
    <thead>
      <tr>
        <th colspan="2">
          <b class="text-subtitle-1 font-weight-black">Basic</b>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Username</td>
        <td>{{ apiData?.username }}</td>
      </tr>
      <tr>
        <td>Full Name</td>
        <td>{{ apiData?.first_name + ' ' + apiData?.last_name }}</td>
      </tr>
      <tr>
        <td>Email</td>
        <td>{{ apiData?.email }}</td>
      </tr>
      <tr>
        <td>Role</td>
        <td>{{ apiData?.role?.title }}</td>
      </tr>
    </tbody>
    <thead class="mt-4">
      <tr>
        <th colspan="2">
          <b class="text-subtitle-1 font-weight-black">Details</b>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Institution</td>
        <td>{{ apiData?.user_detail?.institution }}</td>
      </tr>
      <tr>
        <td>Academic Email</td>
        <td>{{ apiData?.user_detail?.academic_email }}</td>
      </tr>
      <tr>
        <td>Personal Email</td>
        <td>{{ apiData?.user_detail?.personal_email }}</td>
      </tr>
      <tr>
        <td>Phone 1</td>
        <td>{{ apiData?.user_detail?.phone_1 }}</td>
      </tr>
      <tr>
        <td>Phone 2</td>
        <td>{{ apiData?.user_detail?.phone_2 }}</td>
      </tr>
      <tr>
        <td>Program</td>
        <td>{{ apiData?.user_detail?.program }} ({{ formatDateV1(apiData?.user_detail?.program_start) }}~{{ formatDateV1(apiData?.user_detail?.program_end) }})</td>
      </tr>
    </tbody>
    <thead class="mt-4">
      <tr>
        <th colspan="2">
          <b class="text-subtitle-1 font-weight-black">Coop Information ({{ apiData?.coop_terms_count }})</b>
          <p class="text-subtitle-2">Total {{ getFormatedStringFromDays(apiData?.coopDurationInDays) }}</p>
        </th>
      </tr>
    </thead>
    <template v-for="(coop, idx) in apiData?.coop_terms" :key="coop.id">
      <thead class="mt-4">
        <tr>
          <th colspan="2">
            <b class="text-subtitle-2 font-weight-bold">Term {{ idx + 1 }}</b>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Position</td>
          <td>{{ coop?.position }}</td>
        </tr>
        <tr>
          <td>Ministry</td>
          <td>{{ coop?.ministry?.title }}</td>
        </tr>
        <tr>
          <td>Term</td>
          <td>{{ coop?.term }} ({{ formatDateV1(coop?.term_start) }}~{{ formatDateV1(coop?.term_end) }})</td>
        </tr>
      </tbody>
    </template>
  </v-table>
</template>

<script setup>
import { ref } from 'vue'
import { getFormatedStringFromDays, formatDateV1 } from '@/utils/index.js'

    const { renderElement, apiData } = defineProps({  renderElement: Boolean, apiData: Object })
    const desserts = ref([
          {
            name: 'Frozen Yogurt',
            calories: 159,
          },
          {
            name: 'Ice cream sandwich',
            calories: 237,
          },
          {
            name: 'Eclair',
            calories: 262,
          },
          {
            name: 'Cupcake',
            calories: 305,
          },
          {
            name: 'Gingerbread',
            calories: 356,
          },
          {
            name: 'Jelly bean',
            calories: 375,
          },
          {
            name: 'Lollipop',
            calories: 392,
          },
          {
            name: 'Honeycomb',
            calories: 408,
          },
          {
            name: 'Donut',
            calories: 452,
          },
          {
            name: 'KitKat',
            calories: 518,
          },
        ])
</script>