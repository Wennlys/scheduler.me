import { takeLatest, call, put, all } from 'redux-saga/effects';
import { toast } from 'react-toastify'

import api from '~/services/api';

import { updateProfileSuccess, updateProfileFailure } from "~/store/modules/user/actions";

export function* updateProfile({ payload }) {
  try {
    const { user_name, first_name, last_name, email, ...rest } = payload.data;

    const profile = Object.assign(
      { user_name, first_name, last_name, email },
      rest.current_password ? rest : {}
    );

    const response = yield call(api.put, 'users', profile);

    toast.success('Perfil atualizado!');

    yield put(updateProfileSuccess(response.data));
  } catch (e) {
    toast.error('Erro ao atualizar, verifique seus dados');
    yield put(updateProfileFailure());
  }
}

export default all([
  takeLatest('@user/UPDATE_PROFILE_REQUEST', updateProfile),

]);
