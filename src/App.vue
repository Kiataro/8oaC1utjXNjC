
<template>
  <div id="app">
    <el-card class="layout">
    <el-form ref="form" :rules="rules" :model="form" class="form__">
      <div class="title__">Форма обратной связи</div>
      <el-form-item label="Имя" prop="name">
        <el-input v-model="form.name"></el-input>
      </el-form-item>
      <el-form-item label="Фамилия" prop="surname">
        <el-input v-model="form.surname"></el-input>
      </el-form-item>
      <el-form-item label="Email" prop="email">
        <el-input v-model="form.email"></el-input>
      </el-form-item>
      <el-form-item label="Дата рождения" prop="birthday">
         <el-date-picker
                 v-model="form.birthday"
                 type="date">
         </el-date-picker>
      </el-form-item>
      <el-form-item label="Телефон" v-mask="'+7 (###) ###-##-##'" prop="phone">
        <el-input v-model="form.phone"></el-input>
      </el-form-item>
      <el-form-item label="Город" prop="city">
        <el-input v-model="form.city"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="success" @click="onSubmit('form')">Отправить заявку</el-button>
      </el-form-item>
    </el-form>
    </el-card>
    <!-- Dialog -->
    <el-dialog
            :visible.sync="dialogVisible"
            width="30%"
            >
      <span>Данные успешно сохранены!</span>
      <div class="ui-success">
        <svg class="animated-check" viewBox="0 0 24 24">
          <path d="M4.1 12.7L9 17.6 20.3 6.3" fill="none"/>
        </svg>
      </div>
    </el-dialog>

  </div>
</template>
<script>
import Vue from "vue";
import axios from "axios";

Vue.use(axios);
export default {
  data() {
    return {
      dialogVisible: false,
      form: {
        name: '',
        surname: '',
        email: '',
        birthday: '',
        phone: '',
        city: ''
      },
      rules: {
        name: [
          { required: true, message: 'Введите имя', trigger: 'change' }
        ],
        surname: [
          { required: true, message: 'Введите фамилию', trigger: 'blur' }
        ],
        email: [
          { required: true, message: 'Введите e-mail', trigger: 'blur' },
          { type: 'email', message: 'E-mail задан некорректно', trigger: ['blur', 'change'] }
        ],
        birthday: [
          { required: true, message: 'Введите дату рождения', trigger: 'blur' }
        ],
        phone: [
          { required: true, message: 'Введите телефон', trigger: 'blur' },
          { min: 18, max: 18, message: 'Телефон задан некорректно', trigger: 'blur' }
        ],
        city: [
          { required: true, message: 'Введите город', trigger: 'blur' }
        ],
      }
    }
  },
  methods: {
    onSubmit(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let data = JSON.stringify({
            form: this.form,
          });
          axios.post('/post.php', data, {
            headers: { 'Content-Type': 'application/json' }}).then((response) => this.dialogVisible = true)
        } else {
          this.$message({
            showClose: true,
            message: 'Форма заполнена не полностью или некорректно.',
            type: 'error'
          });
          return false;
        }
      });
    }
  },
}
</script>

<style>
  * {
    margin: 0;
  }
  .layout {
    margin: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%)
  }
  .form__ {
    background: #fff;
    padding: 25px;
  }
  .title__ {
    font-size: 36px;
  }
  .animated-check {
     height: 10em;
     width: 10em;
   }
  .animated-check path {
    fill: none;
    stroke: #7ac142;
    stroke-width: 4;
    stroke-dasharray: 23;
    stroke-dashoffset: 23;
    animation: draw 1s linear forwards;
    stroke-linecap: round;
    stroke-linejoin: round;
  }
  @keyframes draw {
    to {
      stroke-dashoffset: 0;
    }
  }
  #app {
    position: relative;
    min-height: 100vh;
    background: url(assets/bg.jpg);
    background-size: 25%;
    font-family: sans-serif;
    text-align: center;
  }

</style>
