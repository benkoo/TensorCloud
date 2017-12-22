package com.vlotar.demo.service.converter;

import com.vlotar.demo.domain.PiwikLogVisit;
import com.vlotar.demo.domain.User;
import com.vlotar.demo.piwik.request.PiwikLogVisitRequest;
import com.vlotar.demo.piwik.response.PiwikLogVisitResponse;
import com.vlotar.demo.web.request.UserResourceRequest;
import com.vlotar.demo.web.response.UserResourceResponse;
import org.springframework.stereotype.Component;

import java.io.UnsupportedEncodingException;

@Component
public class PiwikLogVisitConverter {
    /**
     * Converts {@link PiwikLogVisit} to {@link PiwikLogVisitResponse}
     *
     * @param user {@link PiwikLogVisit}
     * @return {@link PiwikLogVisitResponse}
     */
    public PiwikLogVisitResponse convert(final PiwikLogVisit piwikLogVisit) {
        return new PiwikLogVisitResponse(piwikLogVisit.getIdvisit(),piwikLogVisit.getIdsite(), piwikLogVisit.getIdvisitor(), piwikLogVisit.getUser_id(), piwikLogVisit.getVisit_last_action_time(),piwikLogVisit.getLocation_ip());
    }

    /**
     * Converts {@link UserResourceRequest} to a domain {@link User}.
     *
     * @param request {@link UserResourceRequest}
     * @return {@link User}
     */
    public PiwikLogVisit convert(final PiwikLogVisitRequest request) throws UnsupportedEncodingException {
        final PiwikLogVisit user = new PiwikLogVisit();
        convertCommonFields(request, user);
        return user;
    }

    /**
     * Converts {@link UserResourceRequest} to a domain {@link User}.
     *
     * @param request {@link UserResourceRequest}
     * @return {@link User}
     */
    public PiwikLogVisit convert(final PiwikLogVisitRequest request, final Long userId) {
        final PiwikLogVisit user = new PiwikLogVisit();
        user.setId(userId);
        convertCommonFields(request, user);
        return user;
    }

    private void convertCommonFields(final PiwikLogVisitRequest request, final PiwikLogVisit user) {
        user.setIdvisit(request.getIdvisit());
        user.setIdvisitor(request.getIdvisitor());
        user.setUser_id(request.getUser_id());
        user.setLocation_ip((request.getLocation_ip()));
        user.setVisit_last_action_time(request.getVisit_last_action_time());
    }
}
