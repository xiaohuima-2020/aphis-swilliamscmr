import parse from 'html-react-parser';

import twigTemplate from './button.twig';
import data from './button.yml';
import secondaryData from './button--secondary.yml';
import unstyledData from './button--unstyled.yml';
import textData from './button--text.yml';
import '../uswds.es6';

const settings = {
  title: 'USWDS/Button',
  parameters: {
    docs: {
      description: {
        component: "See https://designsystem.digital.gov/components/button/ and https://components.designsystem.digital.gov/components/detail/buttons--default.html.",
      },
    },
  }
};

const Default = args => (
  parse(twigTemplate({
    ...args,
  }))
);
Default.args = { ...data };

const Secondary = args => (
  parse(twigTemplate({
    ...args,
  }))
);
Secondary.args = { ...secondaryData };
Secondary.parameters = {
  docs: {
    storyDescription: "See https://designsystem.digital.gov/components/button/ and https://components.designsystem.digital.gov/components/detail/buttons--secondary.html.",
  },
};

const Unstyled = args => (
  parse(twigTemplate({
    ...args,
  }))
);
Unstyled.args = { ...unstyledData };
Unstyled.parameters = {
  docs: {
    storyDescription: "See https://designsystem.digital.gov/components/button/.",
  },
};

const Text = args => (
  parse(twigTemplate({
    ...args,
  }))
);
Text.args = { ...textData };
Text.parameters = {
  docs: {
    storyDescription: "Custom variation, extended from https://designsystem.digital.gov/components/button/.",
  },
};

export default settings;
export { Default, Secondary, Unstyled, Text };
