import parse from 'html-react-parser';

import twigTemplate from './text-styles.twig';
import data from './text-styles.yml';

const settings = {
  title: 'Global/Text Styles',
  argTypes: {
    gesso: {
      table: {
        disable: true
      }
    }
  }
};

const TextStyles = args => (
  parse(twigTemplate({
    ...args,
  }))
);
TextStyles.args = { ...data };

export default settings;
export { TextStyles };
