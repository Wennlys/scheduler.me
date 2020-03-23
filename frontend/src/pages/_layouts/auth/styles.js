import styled from "styled-components";
import { darken } from "polished";

export const Wrapper = styled.div`
  height: 100%;
  background-image: linear-gradient(120deg, #ffe478 0%, #e8c36d 100%);

  display: flex;
  justify-content: center;
  align-items: center;
`;

export const Content = styled.div`
  width: 100%;
  max-width: 315px;
  text-align: center;

  img {
    width: 100px;
    height: 100px;
  }

  form {
    display: flex;
    flex-direction: column;
    margin-top: 30px;

    .regular-checkbox {
      -webkit-appearance: none;
      background-color: #fafafa;
      border: 1px solid #cacece;
      padding: 0;
      border-radius: 3px;
      display: inline-block;

      width: 20px;
      height: 20px;
      position: relative;
    }

    .regular-checkbox:checked:after {
      content: "\\2716";
      font-size: 20px;
      position: absolute;
      top: -3px;
      left: 1px;
      color: #8354b3;
    }

    input {
      background: rgba(255, 255, 255, 0.5);
      border: 0;
      border-radius: 4px;
      height: 44px;
      color: #000;
      padding: 0 15px;
      margin: 0 0 10px;
      text-align: center;

      &:focus::placeholder {
        color: transparent;
      }

      &::placeholder {
        color: rgba(0, 0, 0);
      }
    }

    button {
      width: 100%;
      margin: 5px 0 0;
      height: 44px;
      background: #8354b3;
      color: #fff;
      border: 0;
      border-radius: 4px;
      font-size: 16px;
      transition: background 0.2s;

      a {
        color: #fff;
      }

      &:hover {
        background: ${darken(0.05, "#8354B3")};
      }
    }

    a {
      color: #8354b3;
      margin-top: 15px;
      font-size: 16px;
      opacity: 0.8;

      &:hover {
        opacity: 1;
      }
    }

    label {
      display: flex;
      flex-direction: row;
      justify-content: center;

      div {
        padding: 2px 0 0 10px;
        font-size: 14px;
        color: rgba(0, 0, 0, 0.5);
      }
    }
  }
`;

export const Bottom = styled.div`
  background: rgba(255, 255, 255, 0.4);
  width: 100%;
  max-width: 500px;
  height: 100%;
  max-height: 500px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
`;
