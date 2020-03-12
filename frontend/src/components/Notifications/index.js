import React, { useState } from "react";

import { MdNotifications } from "react-icons/all";

import { Badge, Container, Notification, NotificationList } from "./styles";

const Notifications = () => {
  const [visible, setVisible] = useState(false);

  function handleToggleVisible() {
    setVisible(!visible);
  }

  return (
    <Container>
      <Badge onClick={handleToggleVisible}>
        <MdNotifications color="#7159c1" size={20} />
      </Badge>

      <NotificationList visible={visible}>
        <Notification unread>
          <p>Você tem um novo agendamento para amanhã</p>
          <time>há 2 dias</time>
          <button type="button">Marcar como lida</button>
        </Notification>
        <Notification>
          <p>Você tem um novo agendamento para amanhã</p>
          <time>há 2 dias</time>
          <button type="button">Marcar como lida</button>
        </Notification>
        <Notification>
          <p>Você tem um novo agendamento para amanhã</p>
          <time>há 2 dias</time>
          <button type="button">Marcar como lida</button>
        </Notification>
      </NotificationList>
    </Container>
  );
};

export default Notifications;
