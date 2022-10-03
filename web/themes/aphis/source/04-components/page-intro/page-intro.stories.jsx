import parse from 'html-react-parser';

import twigTemplate from './page-intro.twig';
import data from './page-intro.yml';

const settings = {
  title: 'Components/Page Intro'
};

const PageIntro = args =>
  parse(
    twigTemplate({
      ...args,
    })
  );
PageIntro.args = { ...data };

export default settings;
export { PageIntro };
