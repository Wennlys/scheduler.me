import React from "react";
import PropTypes from "prop-types";

import { Wrapper, Content, Bottom } from "./styles";

const AuthLayout = ({ children }) => {
  return (
    <Wrapper>
      <Bottom>
        <Content>{children}</Content>
      </Bottom>
    </Wrapper>
  );
};

AuthLayout.propTypes = {
  children: PropTypes.element.isRequired
};

export default AuthLayout;
