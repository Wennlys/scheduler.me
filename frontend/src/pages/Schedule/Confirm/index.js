import React from 'react';

import { MdChevronLeft } from "react-icons/all";

import { Container } from "../styles";
import { Content } from "./styles";

import api from '~/services/api';
import { formatDistance } from "date-fns";
import pt from "date-fns/locale/pt";
import history from "~/services/history";

const Confirm = ({ page, setPage }) => {

  async function handleConfirm() {
    await api.post('appointments', {}, {
      params: {
        provider_id: page.state.provider.id,
        date: page.state.dateTime
      }
    });

    history.push('/dashboard');
  }

  return (
    <Container>
      <button
        type='button'
        onClick={ () => setPage(page => ({ number: 1, state: { ...page.state } })) }>
        <MdChevronLeft size={ 48 } color='#ffffff'/>
      </button>
      <Content>
        <img src={ page.state.provider.avatar.url } alt='avatar'/>
        <strong>{ `${ page.state.provider.first_name } ${ page.state.provider.last_name }` }</strong>
        <p>{
            formatDistance(
              new Date(page.state.dateTime.replace(/-/g, "/")),
              new Date(),
              { addSuffix: true, locale: pt})
        }</p>
        <button type="button" onClick={ handleConfirm }>Realizar agendamento</button>
      </Content>
      <button />
    </Container>
  );
};

export default Confirm;
