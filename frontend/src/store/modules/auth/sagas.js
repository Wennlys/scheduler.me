import { takeLatest, call, put, all } from 'redux-saga/effects';
import { toast } from "react-toastify";

import history from "~/services/history";
import api from '~/services/api';

import { signInSuccess, signFailure} from "./actions";

export function* signIn({ payload }) {
  try {
    const { login, password } = payload;

    const response = yield call(
      api.post,
      'sessions',
      {
        login,
        password
      });

    const { token, user } = response.data;

    yield put(signInSuccess(token, user));

    history.push('/dashboard');
  } catch (e) {
    toast.error('Falha ao logar-se, verifique seus dados.');
    yield put(signFailure());
  }
}

export function* signUp({ payload }) {
  try {
    const { user_name, first_name, last_name, email, password, provider } = payload;

    yield call(
      api.post,
      'users',
      {
        user_name, first_name, last_name, email, password, provider: Boolean(provider)
      }
    );

    toast.success('Cadastro feito com sucesso! Faça seu login para conectar-se.')
    history.push('/');
  } catch (e) {
    console.tron.log(e);
    toast.error('Falha no cadastro, verifique seus dados.');
    yield put(signFailure());
  }
}

export default all([
  takeLatest('@auth/SIGN_IN_REQUEST', signIn),
  takeLatest('@auth/SIGN_UP_REQUEST', signUp)
]);
