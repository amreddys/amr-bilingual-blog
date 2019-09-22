export class Errors {
    /**
     * Create a new Errors instance.
     */
    constructor() {
        this.errors = {};
    }


    /**
     * Determine if an errors exists for the given field.
     *
     * @param {string} field
     */
    has(field) {
        return this.errors.hasOwnProperty(field);
    }


    /**
     * Determine if we have any errors.
     */
    any() {
        return Object.keys(this.errors).length > 0;
    }


    /**
     * Retrieve the error message for a field.
     *
     * @param {string} field
     */
    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }


    /**
     * Record the new errors.
     *
     * @param {object} errors
     */
    record(errors) {
        this.errors = errors;
    }


    /**
     * Clear one or all error fields.
     *
     * @param {string|null} field
     */
    clear(field) {
        if (field) {
            delete this.errors[field];

            return;
        }

        this.errors = {};
    }
}


export class Form {
    /**
     * Create a new Form instance.
     *
     * @param {object} data
     */
    constructor(data) {
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();
    }


    /**
     * Fetch all relevant data for the form.
     */
    data() {
        let data = {};

        for (let property in this.originalData) {
            data[property] = this[property];
        }

        return data;
    }


    /**
     * Reset the form fields.
     */
    reset() {
        for (let field in this.originalData) {
            this[field] = this.originalData[field];
        }

        this.errors.clear();
    }


    /**
     * Send a POST request to the given URL.
     * .
     * @param {string} url
     */
    post(url) {
        return this.submit('post', url);
    }


    /**
     * Send a PUT request to the given URL.
     * .
     * @param {string} url
     */
    put(url) {
        return this.submit('put', url);
    }


    /**
     * Send a PATCH request to the given URL.
     * .
     * @param {string} url
     */
    patch(url) {
        return this.submit('patch', url);
    }


    /**
     * Send a DELETE request to the given URL.
     * .
     * @param {string} url
     */
    delete(url) {
        return this.submit('delete', url);
    }


    /**
     * Submit the form.
     *
     * @param {string} requestType
     * @param {string} url
     */
    submit(requestType, url) {
        return new Promise((resolve, reject) => {
            axios[requestType](url, this.data())
                .then((response) => {
                    this.onSuccess(response.data);
                    resolve(response.data);
                })
                .catch((error) => {
                    this.onFail(error.response.data.errors);
                    reject(error.response.data.errors);
                });
        });
    }


    /**
     * Handle a successful form submission.
     *
     * @param {object} data
     */
    onSuccess(data) {
        Vue.toasted.success(data.message);
        this.reset();
    }


    /**
     * Handle a failed form submission.
     *
     * @param {object} errors
     */
    onFail(errors) {
        this.errors.record(errors);
    }
}


/* Templates required for FormProcessor */
let srbuttonComponent = {
    template: `<div class="form-group">
        <button class="btn btn-primary" :disabled="this.$parent.form.errors.any()"><slot></slot></button>
        <button class="btn btn-secondary" type="reset">Reset Form</button>
    </div>`,
}
let textInputComponet = {
    template: `<div class="form-group">
       <label :for="fieldName">{{labelText}}</label>
       <input type="text" class="form-control" :id="fieldName" :readonly="readonly" @change="$emit('change')" @keyup="$emit('keyup')" :placeholder="placeholderText" v-model.trim="form[fieldName]">
       <small class="form-text text-danger" v-if="form.errors.has(fieldName)" v-text="form.errors.get(fieldName)"></small>
    </div>`,
    props: ['fieldName', 'labelText', 'placeholderText', 'readonly'],
    data: function() {
        return {form: this.$parent.form}
    }
}

let passwordInputComponet = {
    template: `<div class="form-group">
       <label :for="fieldName">{{labelText}}</label>
       <input type="password" class="form-control" autocomplete="new-password" :id="fieldName" :placeholder="placeholderText" v-model.trim="form[fieldName]">
       <small class="form-text text-danger" v-if="form.errors.has(fieldName)" v-text="form.errors.get(fieldName)"></small>
    </div>`,
    props: ['fieldName', 'labelText', 'placeholderText'],
    data: function() {
        return {form: this.$parent.form}
    }
}

let dateInputComponet = {
    template: `<div class="form-group">
       <label :for="fieldName">{{labelText}}</label>
       <input type="date" class="form-control"  :readonly="readonly" :id="fieldName" v-model.trim="form[fieldName]">
       <small class="form-text text-danger" v-if="form.errors.has(fieldName)" v-text="form.errors.get(fieldName)"></small>
    </div>`,
    props: ['fieldName', 'labelText', 'placeholderText', 'readonly'],
    data: function() {
        return {form: this.$parent.form}
    }
}

let selectInputComponet = {
    template: `<div class="form-group">
       <label :for="fieldName">{{labelText}}</label>
       <select class="form-control" :id="fieldName"  :disabled="disabled" @change="$emit('change')" v-model.trim="form[fieldName]">
          <option value=''>Select an Option</option>
          <option v-for="(option,key) in options" :value="key">{{option}}</option>
       </select>
       <small class="form-text text-danger" v-if="form.errors.has(fieldName)" v-text="form.errors.get(fieldName)"></small>
    </div>`,
    props: ['fieldName', 'labelText', 'options', 'disabled'],
    data: function() {
        return {form: this.$parent.form}
    }
}
Vue.component('srbuttons',srbuttonComponent);
Vue.component('text-input',textInputComponet);
Vue.component('password-input',passwordInputComponet);
Vue.component('select-input',selectInputComponet);
Vue.component('date-input',dateInputComponet);