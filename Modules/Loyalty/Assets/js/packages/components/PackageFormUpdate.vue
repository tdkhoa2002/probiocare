<template>
  <div class="div">
    <div class="content-header">
      <h1>
        {{ trans(`packages.title.${packageTitle}`) }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/backend">Home</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.loyalty.package.index' }">
          {{ trans("packages.list resource") }}
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{ name: 'admin.loyalty.package.create' }">
          {{ trans(`packages.title.${packageTitle}`) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>
    <el-tabs type="border-card">
      <el-tab-pane label="Package">
        <el-form ref="formPackageData" :model="packageData" label-width="120px" label-position="top"
          @keydown="form.errors.clear($event.target.name)">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-body">
                  <el-tabs v-model="activeTab">
                    <el-tab-pane v-for="(localeArray, locale) in locales" :key="localeArray.name"
                      :label="localeArray.name" :name="locale">
                      <span slot="label" :class="{ error: form.errors.has(locale) }"><i
                          :class="'flag-icon flag-icon-' + locale"></i> &nbsp;
                        {{ localeArray.name }}</span>
                      <el-form-item :label="trans('packages.form.title')" :class="{
                        'el-form-item is-error': form.errors.has(
                          locale + '.title'
                        ),
                      }">
                        <el-input v-model="packageData[locale].title"></el-input>
                        <div v-if="form.errors.has(locale + '.title')" class="el-form-item__error"
                          v-text="form.errors.first(locale + '.title')"></div>
                      </el-form-item>
                      <el-form-item :label="trans('packages.form.description')" :class="{
                        'el-form-item is-error': form.errors.has(
                          locale + '.description'
                        ),
                      }">
                        <el-input v-model="packageData[locale].description" type="textarea" :rows="4"></el-input>
                        <div v-if="form.errors.has(locale + '.description')" class="el-form-item__error"
                          v-text="form.errors.first(locale + '.description')"></div>
                      </el-form-item>
                    </el-tab-pane>
                  </el-tabs>
                  <div class="row">
                    <div class="col-lg-6">
                      <el-form-item :label="trans('packages.form.currency_stake_id')" :class="{
                        'el-form-item is-error':
                          form.errors.has('currency_stake_id'),
                      }">
                        <el-select v-model="packageData.currency_stake_id" placeholder="Select">
                          <el-option v-for="item in currencies" :key="item.id" :label="item.title"
                            :value="item.id"></el-option>
                        </el-select>
                        <div v-if="form.errors.has('currency_stake_id')" class="el-form-item__error"
                          v-text="form.errors.first('currency_stake_id')"></div>
                      </el-form-item>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <el-form-item :label="trans('packages.form.principal_convert_currency')" :class="{
                        'el-form-item is-error':
                          form.errors.has('currency_reward_id'),
                      }">
                        <el-select v-model="packageData.currency_reward_id" placeholder="Select">
                          <el-option v-for="item in currencies" :key="item.id" :label="item.title"
                            :value="item.id"></el-option>
                        </el-select>
                        <div v-if="form.errors.has('currency_reward_id')" class="el-form-item__error"
                          v-text="form.errors.first('currency_reward_id')"></div>
                      </el-form-item>
                    </div>
                    <div class="col-lg-6">
                      <el-form-item :label="trans('packages.form.principal_convert_rate')" :class="{
                        'el-form-item is-error':
                          form.errors.has('principal_convert_rate'),
                      }">
                        <el-input-number v-model="packageData.principal_convert_rate" :min="0"></el-input-number>
                        <div v-if="form.errors.has('principal_convert_rate')" class="el-form-item__error"
                          v-text="form.errors.first('principal_convert_rate')"></div>
                      </el-form-item>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <el-form-item :label="trans('packages.form.currency_cashback_id')" :class="{
                        'el-form-item is-error':
                          form.errors.has('currency_cashback_id'),
                      }">
                        <el-select v-model="packageData.currency_cashback_id" placeholder="Select">
                          <el-option v-for="item in currencies" :key="item.id" :label="item.title"
                            :value="item.id"></el-option>
                        </el-select>
                        <div v-if="form.errors.has('currency_cashback_id')" class="el-form-item__error"
                          v-text="form.errors.first('currency_cashback_id')"></div>
                      </el-form-item>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <el-form-item :label="trans('packages.form.term_matching')" :class="{
                        'el-form-item is-error':
                          form.errors.has('term_matching'),
                      }">
                        <el-input-number v-model="packageData.term_matching" :min="0"></el-input-number>
                        <div v-if="form.errors.has('term_matching')" class="el-form-item__error"
                          v-text="form.errors.first('term_matching')"></div>
                      </el-form-item>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <el-form-item :label="trans('packages.form.min_stake')" :class="{
                        'el-form-item is-error': form.errors.has('min_stake'),
                      }">
                        <el-input-number v-model="packageData.min_stake" :min="0"></el-input-number>
                        <div v-if="form.errors.has('min_stake')" class="el-form-item__error"
                          v-text="form.errors.first('min_stake')"></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item :label="trans('packages.form.max_stake')" :class="{
                        'el-form-item is-error': form.errors.has('max_stake'),
                      }">
                        <el-input-number v-model="packageData.max_stake" :min="0"></el-input-number>
                        <div v-if="form.errors.has('max_stake')" class="el-form-item__error"
                          v-text="form.errors.first('max_stake')"></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item :label="trans('packages.form.hour_reward')" :class="{
                        'el-form-item is-error': form.errors.has('hour_reward'),
                      }">
                        <el-input-number v-model="packageData.hour_reward" :min="0"></el-input-number>
                        <div v-if="form.errors.has('hour_reward')" class="el-form-item__error"
                          v-text="form.errors.first('hour_reward')"></div>
                      </el-form-item>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <el-form-item :label="trans('packages.form.start_date')" :class="{
                        'el-form-item is-error':
                          form.errors.has('start_date'),
                      }">
                        <el-date-picker v-model="packageData.start_date" type="date" placeholder="Pick a day"
                          value-format="yyyy-MM-dd">
                        </el-date-picker>
                        <div v-if="form.errors.has('start_date')" class="el-form-item__error"
                          v-text="form.errors.first('start_date')"></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item :label="trans('packages.form.end_date')" :class="{
                        'el-form-item is-error': form.errors.has('end_date'),
                      }">
                        <el-date-picker v-model="packageData.end_date" type="date" placeholder="Pick a day"
                          value-format="yyyy-MM-dd">
                        </el-date-picker>
                        <div v-if="form.errors.has('end_date')" class="el-form-item__error"
                          v-text="form.errors.first('end_date')"></div>
                      </el-form-item>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <el-form-item :label="trans('packages.form.principal_is_stake_currency')" :class="{
                        'el-form-item is-error': form.errors.has('principal_is_stake_currency'),
                      }">
                        <el-switch v-model="packageData.principal_is_stake_currency" active-color="#13ce66"
                          inactive-color="#ff4949">
                        </el-switch>
                        <div v-if="form.errors.has('principal_is_stake_currency')" class="el-form-item__error"
                          v-text="form.errors.first('principal_is_stake_currency')"></div>
                      </el-form-item>
                    </div>
                    <div class="col-md-4">
                      <el-form-item :label="trans('packages.form.require_entry')" :class="{
                        'el-form-item is-error': form.errors.has('require_entry'),
                      }">
                        <el-switch v-model="packageData.require_entry" active-color="#13ce66" inactive-color="#ff4949">
                        </el-switch>
                        <div v-if="form.errors.has('require_entry')" class="el-form-item__error"
                          v-text="form.errors.first('require_entry')"></div>
                      </el-form-item>
                    </div>
                  </div>
                  <single-media :entity-id="packageData.id" zone="PACKAGE_ICON" entity="Modules\Loyalty\Entities\Package"
                    @single-file-selected="selectSingleFile($event, 'packageData')"></single-media>
                  <br>
                  <el-form-item :label="trans('packages.form.status')" :class="{
                    'el-form-item is-error': form.errors.has('status'),
                  }">
                    <el-switch v-model="packageData.status" active-color="#13ce66" inactive-color="#ff4949">
                    </el-switch>
                    <div v-if="form.errors.has('status')" class="el-form-item__error"
                      v-text="form.errors.first('status')"></div>
                  </el-form-item>
                  <el-form-item>
                    <el-button :loading="loading" type="primary" @click="onSubmit()">
                      {{ trans("core.save") }}
                    </el-button>
                    <el-button @click="onCancel()">
                      {{ trans("core.button.cancel") }}
                    </el-button>
                  </el-form-item>
                </div>
              </div>
            </div>
          </div>
        </el-form>
      </el-tab-pane>
      <el-tab-pane label="Package Terms">
        <PackageTermTable :package-id="+packageId" :locales="locales"></PackageTermTable>
      </el-tab-pane>
      <el-tab-pane label="Commission">
        <CommissionTable :package-id="+packageId" :locales="locales"></CommissionTable>
      </el-tab-pane>
    </el-tabs>
    <button v-show="false" v-shortkey="['b']" @shortkey="pushRoute({ name: 'admin.loyalty.package.index' })"></button>
  </div>
</template>

<script>
import axios from "axios";
import Form from "form-backend-validation";
import FormErrors from "../../../../../Core/Assets/js/components/FormErrors.vue";
import ShortcutHelper from "../../../../../Core/Assets/js/mixins/ShortcutHelper";
import SingleMedia from "../../../../../Media/Assets/js/components/SingleMedia.vue";
import SingleFileSelector from "../../../../../Media/Assets/js/mixins/SingleFileSelector";
import PackageTermTable from "./PackageTermTable";
import CommissionTable from "./CommissionTable.vue";

export default {
  components: {
    FormErrors,
    SingleMedia,
    PackageTermTable,
    CommissionTable
  },
  mixins: [ShortcutHelper, SingleFileSelector],
  props: {
    locales: {
      default: null,
      type: Object,
    },
    packageTitle: {
      default: null,
      type: String,
    },
  },
  data() {
    return {
      packageData: window
        ._(this.locales)
        .keys()
        .map((locale) => [
          locale,
          {
            title: "",
            description: "",
          },
        ])
        .fromPairs()
        .merge({
          id: null,
          currency_stake_id: "",
          currency_reward_id: "",
          currency_cashback_id: "",
          hour_reward: 1,
          min_stake: 0,
          max_stake: 0,
          start_date: "",
          end_date: "",
          status: true,
          principal_is_stake_currency: true,
          require_entry: false,
          term_matching: 0
        })
        .value(),
      form: new Form(),
      activeTab: window.AsgardCMS.currentLocale || "en",
      loading: false,
      currencies: [],
      packageTerms: [],
      packageId: this.$route.params.packageId
    };
  },
  created() {
    this.fetchArrCurrency();
    this.fetchPackage();
  },
  mounted() { },
  destroyed() {
    $(".publicUrl").hide();
  },
  methods: {
    onSubmit() {
      this.form = new Form(this.packageData);
      this.loading = true;

      this.form
        .post(this.getRoute())
        .then((response) => {
          this.loading = false;
          this.$message({
            type: "success",
            message: response.message,
          });
        })
        .catch((error) => {
          console.log(error);
          this.loading = false;
          this.$notify.error({
            title: "Error",
            message: "There are some errors in the form.",
          });
        });
    },
    onCancel() {
      this.pushRoute({
        name: "admin.loyalty.package.index",
      });
    },
    fetchArrCurrency() {
      axios.get(route("api.wallet.currency.all")).then((response) => {
        this.currencies = response.data.data;
      });
    },
    fetchPackage() {
      this.loading = true;
      axios
        .get(
          route("api.loyalty.package.find", {
            packageId: this.$route.params.packageId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.packageData = response.data.data;
          console.log(this.packageData);
        });
    },
    getRoute() {
      return route("api.loyalty.package.update", {
        packageLoyalty: this.$route.params.packageId,
      });
    },
  },
};
</script>