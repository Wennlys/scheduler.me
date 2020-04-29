import produce from "immer";

const INITIAL_STATE = {
  token: null,
  provider: false,
  signed: false,
  loading: false,
};

export default function auth(state = INITIAL_STATE, action) {
  switch (action.type) {
    case '@auth/SIGN_IN_SUCCESS' :
      return produce(state, draft => {
        draft.token = action.payload.token;
        draft.signed = true;
        draft.provider = action.payload.user.provider;
      })
    default:
      return state;
  }
}
