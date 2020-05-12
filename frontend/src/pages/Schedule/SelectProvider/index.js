import React, { useEffect, useState } from 'react';

import api from '~/services/api';

import { Container } from '../styles';
import { Content } from './styles';

const SelectProvider = ({ setPage }) => {
  const [providers, setProviders] = useState([]);

  useEffect(() => {
    async function loadProviders() {
      const response = await api.get('providers');

      setProviders(response.data);
    }

    loadProviders();
  }, [])

  function handleClick (provider) {
    setPage({ number: 1, state: { provider } });
  }

  return (
      <Container>
        <Content>
          <ul>
            { providers.map(provider => (
              <li key={provider.id} onClick={() => handleClick(provider)}>
                <img src={ provider.avatar.url } alt='profile'/>
                <strong>{ provider.first_name }</strong>
                <strong>{ provider.last_name }</strong>
              </li>
            ))}
          </ul>
        </Content>
      </Container>
  );
};

export default SelectProvider;
