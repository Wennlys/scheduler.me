import styled, { css } from "styled-components";
import PerfectScrollbar from 'react-perfect-scrollbar';
import { lighten } from "polished";

export const NotificationList = styled.div`
  width: 260px;
  background: rgba(0, 0, 0, 0.5);
  padding: 20px;
`;

export const Notification = styled.div`
  color: #fff;
  
  & + div {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
  }
  
  p {
    font-size: 13px;
    line-height: 18px;
  }
  
  time {
    font-size: 12px;
    opacity: 0.6;
  }
  
  button {
    font-size: 12px;
    border: 0;
    background: none;
    color: ${lighten(0.2, "#8354b3")};
    padding: 0 5px;
    margin: 0 5px;
    border-left: 1px solid rgba(255, 255, 255, 0.1);
  }
  
  ${props => props.unread && css`
    &::after {
      content: "";
      display: inline-block;
      margin-left: 3px;
      width: 8px;
      height: 8px;
      background: #ff892e;
      border-radius: 50%;
    }`
  }
`;

export const Scroll = styled(PerfectScrollbar)`
  max-height: 260px;
`;
